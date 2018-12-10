<template>
  <div :class="`row-container w-full my-2 ${inSlide ? `row-container-slide flex-column mx-auto` : `flex`}`"
       :style="`${initial && !readonly && !hideHelpers ? `background-color: var(--primary-30);` : `background: var(--white);`}`">
    <div class="move-icon items-center flex justify-center" v-if="!readonly && !inSlide" v-html="moveIcon"></div>
    <slot name="row-slot"></slot>
    <div :class="`delete-hoverable items-center flex justify-center ${!inSlide ? `delete-icon` : ``}`" v-if="!readonly">
      <transition name="fade">
        <div v-if="!deleting" @click="attemptDelete" class="delete-icon-copy my-1 px-2 py-1"
             style="font-size: 15px; text-align: center;">
          Delete&nbsp;{{ inSlide ? 'Slide' : 'Row' }}
        </div>
        <div v-else :class="`${inSlide ? `flex` : `flex-column`}`" style="font-size: 15px; text-align: center;">
          <div @click="handleDelete" class="confirm-delete-icon my-1 px-2 py-1">
            Confirm&nbsp;Delete
          </div>
          <div @click="cancelDelete" class="cancel-delete-icon my-1 px-2 py-1">
            Cancel
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
  import { moveIcon } from '../../utils/icons'

  export default {
    name: 'RowContainer',
    data() {
      return {
        deleting: false,
        timeOut: '',
        moveIcon: moveIcon
      }
    },
    props: {
      id: {
        type: Number,
        required: true
      },
      type: {
        type: String,
        required: true
      },
      readonly: {
        type: Boolean,
        required: false,
        default: () => {
          return false
        }
      },
      inSlide: {
        type: Boolean,
        required: false,
        default: () => {
          return false
        }
      },
      hideHelpers: {
        type: Boolean,
        required: false,
        default: () => { return false }
      },
      initial: {
        type: Boolean,
        required: false,
        default: () => {
          return false
        }
      }
    },
    methods: {
      /**
       * Displays the confirmation buttons
       */
      attemptDelete() {
        if (!this.readonly) {
          this.deleting = true

          this.timeOut = setTimeout(() => {
            this.deleting = false
          }, 3000)
        }
      },

      /**
       * Cancel the deletion
       */
      cancelDelete() {
        if (!this.readonly) {
          clearTimeout(this.timeOut)

          this.deleting = false
        }
      },

      /**
       * Delete a row
       */
      handleDelete() {
        if (!this.readonly) {
          this.$emit('deleteRow', this.id)
        }
      }
    }
  }
</script>

<style scoped>
  .row-container {
    border-bottom: solid 1px #ccc;
    padding: 25px 1%;
    position: relative;
    width: 102%;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    -ms-transition: all 0.2s;
    -o-transition: all 0.2s;
    transition: all 0.2s;
  }

  .row-container-slide {
    border-bottom: none;
    width: 100% !important;
  }

  .delete-hoverable {
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    -ms-transition: all 0.2s;
    -o-transition: all 0.2s;
    transition: all 0.2s;
    background-color: var(--white);
    color: #ff0000;
  }

  .delete-hoverable:hover {
    cursor: pointer;
  }

  .delete-icon {
    position: absolute;
    top: 50%;
    -webkit-transform: translate(100%, -50%);
    -moz-transform: translate(100%, -50%);
    -ms-transform: translate(100%, -50%);
    -o-transform: translate(100%, -50%);
    transform: translate(100%, -50%);
    right: -15px;
  }

  .delete-icon-copy {
    border: solid 1px #ff0000;
    border-radius: 25px;
  }

  .confirm-delete-icon, .cancel-delete-icon {
    border: solid 1px;
    border-radius: 25px;
  }

  .confirm-delete-icon {
    color: #ff0000;
    border-color: #ff0000;
  }

  .cancel-delete-icon {
    color: #aaa;
    border-color: #aaa;
  }

  .move-icon {
    position: absolute;
    left: -40px;
    top: 50%;
    -webkit-transform: translate(0, -50%);
    -moz-transform: translate(0, -50%);
    -ms-transform: translate(0, -50%);
    -o-transform: translate(0, -50%);
    transform: translate(0, -50%);
  }

  .move-icon svg {
    height: 25px;
  }

  .move-icon:hover {
    cursor: pointer;
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }

  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
  {
    opacity: 0;
  }

</style>
