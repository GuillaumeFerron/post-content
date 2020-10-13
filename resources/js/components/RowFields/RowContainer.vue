<template>
  <div :class="`row-container w-full my-2 ${inSlide ? `row-container-slide flex-column mx-auto` : `flex`}`"
       :style="`${initial && !readonly && !hideHelpers ? `background-color: var(--primary-30);` : `background: var(--white);`}`">
    <div class="move-icon items-center flex justify-center" v-if="!readonly && !inSlide" v-html="moveIcon"></div>
    <slot name="row-slot"></slot>
    <div :class="`delete-hoverable items-center flex justify-center ${!inSlide ? `delete-icon` : ``}`" v-if="!readonly">
      <transition name="fade">
        <div v-if="!deleting" @click="attemptDelete" class="delete-icon-copy my-1 px-2 py-1"
             style="font-size: 15px; text-align: center;">
          <svg style="width: 20px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </div>
        <div v-else :class="`${inSlide ? `flex` : `flex-column`}`" style="font-size: 15px; text-align: center;">
          <div @click="handleDelete" class="confirm-delete-icon my-1 px-2 py-1">
            <svg style="width: 20px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div @click="cancelDelete" class="cancel-delete-icon my-1 px-2 py-1">
            <svg style="width: 20px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
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
    border: solid 2px #ff0000;
    border-radius: 25px;
    transition: all 0.2s;
  }

  .delete-icon-copy:hover {
    background-color: #ff0000;
  }

  .delete-icon-copy svg {
    transition: all 0.2s;
  }

  .delete-icon-copy:hover svg {
    stroke: #fff;
  }

  .confirm-delete-icon, .cancel-delete-icon {
    border: solid 2px;
    border-radius: 25px;
  }

  .confirm-delete-icon {
    color: #ff0000;
    border-color: #ff0000;
    transition: all 0.2s;
  }

  .confirm-delete-icon:hover {
    background-color: #ff0000;
  }

  .confirm-delete-icon svg {
    transition: all 0.2s;
  }

  .confirm-delete-icon:hover svg {
    stroke: #fff;
  }

  .cancel-delete-icon {
    color: #aaa;
    border-color: #aaa;
    transition: all 0.2s;
  }

  .cancel-delete-icon:hover {
    background-color: #aaa;
  }

  .cancel-delete-icon svg {
    transition: all 0.2s;
  }

  .cancel-delete-icon:hover svg {
    stroke: #fff;
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
