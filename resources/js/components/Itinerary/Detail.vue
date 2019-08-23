<template>
  <v-data-table
    :headers="headers"
    :items="itineraryDetail"
    class="elevation-1"
  	>
    <template v-slot:items="props">
            
      <td><router-link :to="{ name: 'Detail Itinerary', params: { id: selected[0].id ,dt: props.item.dt } }" class="nav-link "><a>{{ props.item.code }}</a></router-link></td>
      <td>{{ props.item.start }}</td>
      <td>{{ props.item.end }}</td>
      <td class="text-xs-right">{{ props.item.adult_price  | currency}}</td>
      <td class="text-xs-right">{{ props.item.child_price  | currency}}</td>
      <td class="text-xs-right">{{ props.item.child_bed_price  | currency}}</td>
      <td class="text-xs-right">{{ props.item.infant_price  | currency}}</td>
      <td class="text-xs-right">{{ props.item.minimal_dp  | currency}}</td>
      <td class="text-xs-right">{{ props.item.agent_com  | currency}}</td>
      <td class="text-xs-right">{{ props.item.agent_tip  | currency}}</td>
      <td class="text-xs-right">{{ props.item.agent_visa  | currency}}</td>
      <td class="text-xs-right">{{ props.item.agent_tax  | currency}}</td>
      <td class="text-xs-right">{{ props.item.seat_remain }}</td>
    </template>
  </v-data-table>
</template>
<script type="text/javascript">
	export default {
	    data() {
	        return {
	            headers: [
				          { text: 'Code', value: 'code' },
				          { text: 'Start Date', value: 'start_date' },
				          { text: 'End Date', value: 'end_date' },
				          { text: 'Adult Price', value: 'adult_price' },
				          { text: 'CnB Price', value: 'cnb_price' },
				          { text: 'CwB Price', value: 'cwb_price' },
				          { text: 'Infant Price', value: 'infant_price' },
				          { text: 'Minimal DP', value: 'minimal_dp' },
				          { text: 'Agent Com', value: 'agent_com' },
				          { text: 'Tips', value: 'tips' },
				          { text: 'Visa', value: 'visa' },
				          { text: 'Apt Tax', value: 'apt_tax' },
				          { text: 'Seat', value: 'seat' },
			        ],
	        }
	    },
	    props: {
	        itineraryDetail: Array,
	        selected: Array,
	    },
	}
</script>