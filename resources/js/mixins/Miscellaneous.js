export default {
  methods: {
    /**
     * Generates a id slug
     *
     * @param length
     */
    generateId(length = 10) {
      return '_' + Math.random().toString(36).substr(2, length - 1)
    }
  }
}

