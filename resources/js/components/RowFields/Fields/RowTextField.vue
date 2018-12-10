<template>
  <div class="row-text-field-container w-full">
    <textarea :id="`text-input${id}`" v-if="!readonly"
              :value="value"
              class="w-full form-control form-input form-input-bordered py-3 h-auto"
              placeholder="Text" @change="handleTextChange">
    </textarea>
    <div v-else>
      {{ value }}
    </div>
  </div>
</template>

<script>
  export default {
    name: 'RowTextField',
    props: {
      value: {
        type: String,
        default: ''
      },
      id: {
        type: String,
        required: true
      },
      readonly: {
        type: Boolean,
        required: false,
        default: () => { return false }
      }
    },
    methods: {
      /**
       * Update the field value
       */
      handleTextChange() {
        if (!this.readonly) {
          this.$emit('fieldUpdated', this.id, document.getElementById(`text-input${this.id}`).value)
        }
      }
    },
    mounted() {
      /**
       * Register the pasting event as it is not triggered by the change event
       */
      if(document.getElementById(`text-input${this.id}`)) {
        document.getElementById(`text-input${this.id}`).addEventListener('paste', () => {
          this.handleTextChange()
        })
      }
    },
    beforeDestroy() {
      /**
       * Removes the paste listener
       */
      if(document.getElementById(`text-input${this.id}`)) {
        document.getElementById(`text-input${this.id}`).removeEventListener('pause')
      }
    }
  }
</script>
