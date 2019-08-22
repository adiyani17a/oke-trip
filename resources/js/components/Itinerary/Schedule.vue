<template>
	<div>
		<v-timeline>
			<v-timeline-item
				v-for="(item, index) in schedules"
				:key="index"
				color="red lighten-2"
				large
				>
				<template v-slot:opposite>
					<h3>Day {{ index+1 }}</h3>
				</template>
				<v-card class="elevation-2">
					<v-card-title class="headline cyan lighten-5"><h3>{{ item.title }}</h3></v-card-title>
					<v-card-text>
					{{ item.caption }}
					</v-card-text>
				</v-card>
			</v-timeline-item>
		</v-timeline>
	</div>
</template>
<script type="text/javascript">
    export default {
		props:{
			schedules:Array,
		},
	}
</script>