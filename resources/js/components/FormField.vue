<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <draggable v-model="rowFields" @start="drag=true" @end="drag=false">
        <row-container v-for="(row, index) in rowFields"
                       :key="index"
                       :id="row.id"
                       :type="row.type"
                       :initial="!row.value"
                       :hide-helpers="field.hide_helpers"
                       @deleteRow="handleDeleteRow">
          <template slot="row-slot">
            <row-text-field v-if="row.type === 'text'"
                            :value="row.value"
                            :id="row.id"
                            @fieldUpdated="handleFieldUpdate">
            </row-text-field>
            <row-video-field v-else-if="row.type === 'video'"
                             :value="row.value"
                             :id="row.id"
                             :file-manager-url="field.file_manager_url"
                             @fieldUpdated="handleFieldUpdate">
            </row-video-field>
            <row-image-field v-else-if="row.type === 'image'"
                             :value="row.value"
                             :id="row.id"
                             :file-manager-url="field.file_manager_url"
                             @fieldUpdated="handleFieldUpdate">
            </row-image-field>
            <row-carousel-field v-else-if="row.type === 'carousel'"
                                :value="row.value"
                                :id="row.id"
                                @fieldUpdated="handleFieldUpdate"
                                :options="carouselOptions">
            </row-carousel-field>
          </template>
        </row-container>
      </draggable>
      <add-row :options="customizedFieldOptions"
               :hide-helpers="field.hide_helpers"
               @addOption="handleOptionEvent" ></add-row>
    </template>
  </default-field>
</template>

<script>
  import { FormField, HandlesValidationErrors } from 'laravel-nova'
  import RowContainer from './RowFields/RowContainer'
  import RowTextField from './RowFields/Fields/RowTextField'
  import AddRow from './RowFields/AddRow'
  import RowVideoField from './RowFields/Fields/RowVideoField'
  import RowImageField from './RowFields/Fields/RowImageField'
  import RowCarouselField from './RowFields/Fields/RowCarouselField'
  import draggable from 'vuedraggable'
  import Miscellaneous from '../mixins/Miscellaneous'
  import { carouselIcon, imageIcon, textIcon, videoIcon } from '../utils/icons'

  export default {
    components: { RowCarouselField, RowImageField, RowVideoField, AddRow, RowTextField, RowContainer, draggable },
    mixins: [FormField, HandlesValidationErrors, Miscellaneous],
    props: ['resourceName', 'resourceId', 'field'],
    data() {
      return {
        rowFields: [],
        initialRow: {
          id: 0,
          type: 'text',
          value: ''
        },
        fieldOptions: {
          text: {
            name: 'Text',
            value: 'text',
            icon: textIcon
          },
          image: {
            name: 'Image',
            value: 'image',
            icon: imageIcon
          },
          video: {
            name: 'Video',
            value: 'video',
            icon: videoIcon
          },
          carousel: {
            name: 'Carousel',
            value: 'carousel',
            icon: carouselIcon,
            sub_options: ['image', 'video']
          }
        }
      }
    },
    mounted() {
      if (this.field.value) {
        this.rowFields = JSON.parse(this.field.value).data
      } else {
        this.setInitialField()
      }
    },
    methods: {
      /**
       * Set the initial, internal value for the field.
       */
      setInitialField() {
        this.rowFields.push(this.initialRow)
      },

      /**
       * Add a new field to the fields store
       */
      handleOptionEvent(optionType) {
        this.rowFields.push({
          id: this.generateId(),
          type: optionType,
          value: ''
        })
      },

      /**
       * Remove a field from the fields store
       */
      handleDeleteRow(id) {
        const index = this.rowFields.findIndex((elem) => {
          return elem.id === id
        })

        this.rowFields.splice(index, 1)
      },

      /**
       * Update a field in the fields store
       */
      handleFieldUpdate(id, value) {
        const index = this.rowFields.findIndex((elem) => {
          return elem.id === id
        })

        this.rowFields[index].value = value
      },

      /**
       * Fill the given FormData object with the field's internal value.
       */
      fill(formData) {
        formData.append(this.field.attribute, JSON.stringify({ data: this.rowFields }) || '')
      }
    },
    computed: {
      /**
       * Return the carousel options
       *
       * @returns {options|{image, video}}
       */
      carouselOptions() {
        let options = {}
        const carouselFields = this.field.carousel_fields || this.fieldOptions['carousel'].sub_options

        carouselFields.forEach((elem) => {
          options[elem] = this.fieldOptions[elem]
        })

        return options
      },

      /**
       *
       * @returns {fieldOptions|{text, image, video, carousel}}
       */
      customizedFieldOptions() {
        if (this.field.fields) {
          let rowFields = {}
          this.field.fields.forEach((elem) => {
            rowFields[elem] = Object.assign({}, this.fieldOptions[elem])
          })

          return rowFields
        } else {
          return this.fieldOptions
        }
      }
    }
  }
</script>
