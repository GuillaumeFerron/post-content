<template>
  <panel-item
    :field="field">
    <template slot="value">
      <row-container v-for="(row, index) in rowFields"
                     :key="index"
                     :id="row.id"
                     :type="row.type"
                     :readonly="true"
                     @deleteRow="handleDeleteRow">
        <template slot="row-slot">
          <row-text-field v-if="row.type === 'text'"
                          :value="row.value"
                          :readonly="true"
                          :id="row.id">
          </row-text-field>
          <row-video-field v-else-if="row.type === 'video'"
                           :value="row.value"
                           :readonly="true"

                           :id="row.id">
          </row-video-field>
          <row-image-field v-else-if="row.type === 'image'"
                           :value="row.value"
                           :readonly="true"

                           :id="row.id">
          </row-image-field>
          <row-carousel-field v-else-if="row.type === 'carousel'"
                              :value="row.value"
                              :id="row.id"
                              :readonly="true"
          ></row-carousel-field>
        </template>
      </row-container>
    </template>
  </panel-item>
</template>

<script>
  import RowImageField from './RowFields/Fields/RowImageField'
  import RowVideoField from './RowFields/Fields/RowVideoField'
  import RowTextField from './RowFields/Fields/RowTextField'
  import RowCarouselField from './RowFields/Fields/RowCarouselField'
  import RowContainer from './RowFields/RowContainer'

  export default {
    components: { RowImageField, RowVideoField, RowTextField, RowContainer, RowCarouselField },
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    computed: {
      /**
       * Parse the json recovered from the database
       *
       * @returns {*}
       */
      rowFields() {
        return JSON.parse(this.field.value).data
      }
    }
  }
</script>
