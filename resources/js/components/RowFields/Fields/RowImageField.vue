<template>
  <div class="row-image-field-container w-full">
    <div v-if="!value && !readonly" class="submit-url-container justify-around">
      <div class="w-full flex items-center">
        <label :for="`image-url-input${id}`">Please provide the image URL:</label>
        <a :href="fileManagerUrl" target="_blank"
           class="btn btn-default btn-primary text-center w-1/3 ml-auto"
            v-if="fileManagerUrl">
          FileManager
        </a>
      </div>
      <input type="text" :id="`image-url-input${id}`"
             class="w-full form-control form-input form-input-bordered"
             :value="value"
             :placeholder="`Example: https://cms-url.com/storage/image.jpg`">
      <div class="btn btn-default btn-primary text-center clickable"
           @click="handleUrlSubmit">
        Submit
      </div>
    </div>
    <img :src="value" alt="" v-else>
    <p v-if="readonly && value" class="mt-3">{{ value }}</p>
  </div>
</template>

<script>
  export default {
    name: 'RowImageField',
    props: {
      value: {
        type: String,
        default: ''
      },
      id: {
        type: String,
        required: true
      },
      fileManagerUrl: {
        type: String,
        required: false,
        default: () => { return '' }
      },
      readonly: {
        type: Boolean,
        required: false,
        default: () => {
          return false
        }
      }
    },
    methods: {
      /**
       * Update the field value
       */
      handleUrlSubmit() {
        if (!this.readonly) {
          this.$emit('fieldUpdated', this.id, document.getElementById(`image-url-input${this.id}`).value)
        }
      }
    }
  }
</script>

<style scoped>
  .row-image-field-container {
    margin: 5px 0;
    position: relative;
  }

  .submit-url-container {
    height: 150px;
    display: flex;
    -webkit-flex-direction: column;
    -moz-flex-direction: column;
    -ms-flex-direction: column;
    -o-flex-direction: column;
    -khtml-flex-direction: column;
    flex-direction: column;
  }

  .clickable:hover {
    cursor: pointer;
  }

  img {
    width: 500px;
  }
</style>
