<template>
	<v-list two-line>
      <template v-for="(item, index) in route">
        <v-subheader
          v-if="item.header"
          :key="item.header"
        >
          {{ item.header }}
        </v-subheader>

        <v-divider
          v-else-if="item.divider"
          :key="index"
          :inset="item.inset"
        ></v-divider>

        <v-list-tile
          v-else
          :key="item.title"
          avatar
          @click=""
        >
          <v-list-tile-content>
            <v-list-tile-title v-html="item.title"></v-list-tile-title>
            <v-list-tile-sub-title>
            	<i class="far fa-clock"></i>
							{{ item.departure }}<b class="font-bold">&nbsp;{{ item.departure_airport_code }}</b>&nbsp;
							<i class="fas fa-plane-departure"></i>&nbsp;
							<span class="bg-gray-100 px-1 py-1 border ">Flight no <b class="font-bold">{{ item.flight_number }}</b></span>&nbsp;
							<i class="fas fa-plane-arrival"></i>
							<b class="font-bold">{{ item.arrival_airport_code }} </b><i class="far fa-clock"></i> {{ item.arrival }}&nbsp;
            </v-list-tile-sub-title>
          </v-list-tile-content>
        </v-list-tile>
      </template>
    </v-list>
</template>
<script type="text/javascript">
  export default {
      props: {
          route: Array,
      },
  }
</script>