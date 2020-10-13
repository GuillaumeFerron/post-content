<template>
  <div class="row-video-field-container w-full">
    <div v-if="!value && !readonly" class="submit-url-container justify-around">
      <div class="w-full flex items-center ml-1">
        <label :for="`video-url-input${id}`">{{ __('Please provide the video URL') }}</label>
        <a :href="fileManagerUrl" target="_blank"
           class="btn btn-default btn-primary text-center w-1/3 ml-auto"
           v-if="fileManagerUrl">
          {{ __('File Manager') }}
        </a>
      </div>
      <input type="text" :id="`video-url-input${id}`" class="w-full form-control form-input form-input-bordered" :value="value" :placeholder="`${__('Example')}: https://vimeo.com/123456789`">
      <div class="btn btn-default btn-primary text-center clickable" @click="handleUrlSubmit">{{ __('Submit') }} </div>
    </div>
    <div class="w-full" v-else>
      <vimeo-player ref="player" :video-id="vimeoID" :options="{title: '0', byline: '0', portrait: '0', width: inSlide ? '440' : '500'}" v-if="type === 'vimeo'"/>
      <youtube :video-id="youtubeID" v-else-if="type === 'youtube'" width="100%"></youtube>
      <video :src="value" width="100%" v-else></video>
    </div>
    <p v-if="readonly && value">{{ value }}</p>
  </div>
</template>

<script>
  export default {
    name: 'RowVideoField',
    props: {
      id: {
        type: String,
        required: true
      },
      value: {
        type: String,
        default: ''
      },
      fileManagerUrl: {
        type: String,
        required: false,
        default: () => { return '' }
      },
      inSlide: {
        type: Boolean,
        required: false,
        default: () => { return false }
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
      handleUrlSubmit() {
        if(!this.readonly) {
          this.$emit('fieldUpdated', this.id, document.getElementById(`video-url-input${this.id}`).value)
        }
      }
    },
    computed: {
      /**
       * Return the vimeo ID
       *
       * @returns {string}
       */
      vimeoID() {
        return this.value ? this.value.replace('https://', '').replace('www.', '').replace('vimeo.com/', '').split('?')[0] : ''
      },

      /**
       * Return the youtube video ID
       *
       * @returns {string}
       */
      youtubeID() {
        return this.value ? this.value.replace('https://', '').replace('www.', '').replace('youtube.com/', '').replace('watch', '').replace('?v=', '').split('&')[0] : ''
      },


      type() {
        if(this.value) {
          const testValue = this.value.replace('https://', '').replace('www.', '')

          if(new RegExp(/vimeo.com\//).test(testValue)) {
            return 'vimeo'
          } else if(new RegExp(/youtube.com\/watch\?v=/).test(testValue) || new RegExp(/youtu\.be\//).test(testValue)) {
            return 'youtube'
          } else {
            return 'default'
          }
        }
      }
    }
  }
</script>

<style scoped>
  .row-video-field-container {
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
</style>
