<template>
	<div>
		<table class="table" >
			<thead >
				<th v-for="(field, index) in this.fields">
					<div v-html="field">
						{{ field }}
					</div>
				</th>
				
			</thead>
			<tbody  v-if="this.dataItems !== null">
				<tr v-for="(dataItem, index) in this.dataItems.data" >
					<td>
						1
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>
<script type="text/javascript">
	export default {
		mounted() {
        },
	    data() {
	    	return{

	    	}
	    },
	    props: {
            fields: Array,
            dataItems: Object,
        },
        methods:{
        	clickable:function(){
	    		console.log(this.dataItems);
        	}
        }
	}
</script>