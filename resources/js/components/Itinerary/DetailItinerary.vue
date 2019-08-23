<template>
	<div>
		<v-tabs
      v-model="active"
      color="cyan"
      dark
      slider-color="yellow"
    >
      <v-tab
        v-for="(item,index) in tabs"
        :key="index"
        ripple
      >
        {{ item.title }}

      </v-tab>
      <v-tab-item
        v-for="(item,index) in tabs"
        :key="index"
      >
        <v-card flat>
          
        </v-card>
      </v-tab-item>
    </v-tabs>
	</div>
</template>
<script type="text/javascript">
  export default {
    data () {
      return {
        tabs: [{
            title: 'Form Data'
        }, {
            title: 'Itinerary Report'
        }],
        active: null,
      }
    },
    methods: {
      next () {
        const active = parseInt(this.active)
        this.active = (active < 2 ? active + 1 : 0)
      }
    }
  }
</script>