<template>
  <div>
    <v-data-table
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1"
        style="max-width: 1550px"
    ></v-data-table>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        headers: [
          {
            text: 'Date',
            value: 'date',
          },
          { text: 'Context', value: 'context' },
          { text: 'Level', value: 'level' },
          { text: 'Text', value: 'text' },
        ],
        desserts: [ ],
      }
    },

    mounted() {
            axios.get('api/v1/logs')
            .then(response => {
                console.log(response.data.logs)
                this.desserts = response.data.logs
            });
    }
  }
</script>