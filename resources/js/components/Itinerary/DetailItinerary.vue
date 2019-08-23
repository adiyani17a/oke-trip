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
          <v-card-text>{{ text }}</v-card-text>
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
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
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