<template>
  <div class="row-carousel-field-container w-full">
    <div class="carousel-title">Carousel</div>
    <carousel :perPage="1" style="border: solid 1px #aaa; border-radius: 4px; padding: 25px 20px;">
      <slide v-for="(slide, index) in value" :key="`curr-${slide.id}`">
        <row-container :id="slide.id"
                       :type="slide.type"
                       :in-slide="true"
                       :readonly="readonly"
                       @deleteRow="handleDeleteRow">
          <template slot="row-slot">
            <row-image-field v-if="slide.type === 'image'"
                             :value="slide.value"
                             :id="slide.id"
                             :readonly="readonly"
                             @fieldUpdated="handleFieldUpdate">
            </row-image-field>
            <row-video-field v-if="slide.type === 'video'"
                             :value="slide.value"
                             :id="slide.id"
                             :readonly="readonly"
                             :in-slide="true"
                             @fieldUpdated="handleFieldUpdate">
            </row-video-field>
          </template>
        </row-container>
      </slide>
      <slide v-for="(tempSlide, index) in tempSlides" :key="`temp-${tempSlide.id}`">
        <row-container :id="tempSlide.id" :type="tempSlide.type"
                       :in-slide="true"
                       :readonly="readonly"
                       @deleteRow="handleDeleteRow">
          <template slot="row-slot">
            <row-image-field v-if="tempSlide.type === 'image'"
                             :value="tempSlide.value"
                             :id="tempSlide.id"
                             :readonly="readonly"
                             @fieldUpdated="handleFieldUpdate">
            </row-image-field>
            <row-video-field v-if="tempSlide.type === 'video'"
                             :value="tempSlide.value"
                             :id="tempSlide.id"
                             :readonly="readonly"
                             :in-slide="true"
                             @fieldUpdated="handleFieldUpdate">
            </row-video-field>
          </template>
        </row-container>
      </slide>
      <slide v-if="!readonly">
        <add-row :options="options" @addOption="handleOptionEvent" :add-slide="true"></add-row>
      </slide>
    </carousel>
  </div>
</template>

<script>
  import RowImageField from './RowImageField'
  import RowVideoField from './RowVideoField'
  import AddRow from '../AddRow'
  import RowContainer from '../RowContainer'
  import Miscellaneous from '../../../mixins/Miscellaneous'

  export default {
    name: 'RowCarouselField',
    components: { RowContainer, AddRow, RowVideoField, RowImageField },
    mixins: [Miscellaneous],
    data() {
      return {
        tempSlides: []
      }
    },
    props: {
      id: {
        type: String,
        required: true
      },
      value: {
        type: String,
        default: ''
      },
      readonly: {
        type: Boolean,
        required: false,
        default: () => {
          return false
        }
      },
      options: {
        type: Object,
        required: false,
        default: () => {
          return []
        }
      }
    },
    methods: {
      /**
       * Select a carousel field
       *
       * @param optionType
       */
      handleOptionEvent(optionType) {
        if (!this.readonly) {
          this.tempSlides.push({
            id: this.generateId(),
            type: optionType,
            value: ''
          })
        }
      },

      /**
       * Update the field value
       *
       * @param id
       * @param value
       */
      handleFieldUpdate(id, value) {
        if (!this.readonly) {
          const index = this.tempSlides.findIndex((elem) => {
            return elem.id === id
          })

          let updatedSlides = []

          this.tempSlides[index].value = value

          /**
           * The slide already exists
           */
          if (this.value) {
            const existIndex = this.value.findIndex((elem) => {
              return elem.id === id
            })

            updatedSlides = this.value.slice(0)

            if (existIndex !== -1) {
              updatedSlides[existIndex] = this.tempSlides[index]
            } else {
              updatedSlides.push(this.tempSlides[index])
            }
          }
          /**
           * The slide doesn't exist
           */
          else {
            updatedSlides.push(this.tempSlides[index])
          }

          /**
           * Update the store value
           */
          this.$emit('fieldUpdated', this.id, updatedSlides)
          /**
           * Removes the slide from the temporary slides
           */
          this.tempSlides.splice(index, 1)
        }
      },

      /**
       * Removes a slide
       *
       * @param id
       */
      handleDeleteRow(id) {
        if (!this.readonly) {
          const index = this.tempSlides.findIndex((elem) => {
            return elem.id === id
          })

          if (this.value) {
            const existIndex = this.value.findIndex((elem) => {
              return elem.id === id
            })

            if (existIndex !== -1) {
              let updatedSlides = []

              updatedSlides = this.value.slice(0)
              updatedSlides.splice(existIndex, 1)

              this.$emit('fieldUpdated', this.id, updatedSlides)
            }
          }

          this.tempSlides.splice(index, 1)
        }
      }
    }
  }
</script>

<style scoped>
  .row-carousel-field-container {
    position: relative;
    /*border: solid 1px #aaa;*/
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
  }

  .carousel-title {
    position: absolute;
    top: 5px;
    left: 5px;
    color: #aaa;
  }
</style>
