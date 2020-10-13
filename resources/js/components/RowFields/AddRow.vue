<template>
  <div :class="`add-row-container ${addSlide ? `h-full w-full` : `mt-3 add-row-slide`}`">
    <transition>
      <div :class="`add-icon add-hoverable flex justify-center items-center ${addSlide ? `h-full` : ``}`"
           v-if="!clicked" @click="clicked=true" @mouseenter="changeSvgColor($event, '#fff')"
           @mouseleave="changeSvgColor($event, 'var(--primary)')">
        <div  v-html="addIcon"></div>
      </div>
      <div :class="`flex justify-around items-center ${addSlide ? `h-full` : ``} py-2`"
           :style="`border-radius: 4px; ${!addSlide && !hideHelpers ? `background: var(--primary-30);` : `background: var(--white);`}`"
           v-else>
        <div v-for="option in options" :key="option.name" class="field-option add-hoverable"
             @click="handleOptionClick(option.value)" @mouseenter="changeSvgColor($event, '#fff')"
             @mouseleave="changeSvgColor($event, 'var(--primary)')">
          <div v-html="option.icon" class="option-icon mx-auto">
          </div>
          <div class="text-center">
            {{ option.name }}
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  import { addIcon } from '../../utils/icons'

  export default {
    name: 'AddRow',
    data() {
      return {
        clicked: false,
        addIcon: addIcon
      }
    },
    props: {
      options: {
        type: Object,
        required: true
      },
      addSlide: {
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
      default: {
        type: Boolean,
        default: false
      }
    },
    mounted() {
      this.clicked = this.default
    },
    methods: {
      /**
       * Display the sldies options
       *
       * @param option
       */
      handleOptionClick(option) {
        this.resetClicked()
        this.$emit('addOption', option)
      },

      /**
       * Put the add row container in initial state
       */
      resetClicked() {
        this.clicked = false
      },

      /**
       * Make sure to change the svg icon color when hovering
       *
       * @param e
       * @param color
       */
      changeSvgColor(e, color = 'var(--primary)') {
        e.target.childNodes[0].childNodes[0].style.fill = color
      }
    }
  }
</script>

<style scoped>
  .add-hoverable {
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    -ms-transition: all 0.2s;
    -o-transition: all 0.2s;
    transition: all 0.2s;
    border: solid 1px var(--primary);
    background-color: var(--white);
    color: var(--primary);
  }

  .add-hoverable:hover {
    cursor: pointer;
    background-color: var(--primary);
    border: solid 1px var(--white);
    color: var(--white)
  }

  .add-row-slide {
    width: 102%;
  }

  .add-icon {
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    padding: 5px 0;
  }

  .add-icon svg {
    height: 40px;
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    -ms-transition: all 0.2s;
    -o-transition: all 0.2s;
    transition: all 0.2s;
  }

  .add-icon:hover svg {
    fill: var(--white);
  }

  .field-option {
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    padding: 5px;
    width: 15%;
  }

  .field-option .option-icon svg {
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
  }

  .field-option:hover .option-icon svg {
    fill: var(--white);
  }

  .option-icon {
    width: 30px;
  }
</style>
