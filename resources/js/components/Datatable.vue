<template>
	<div>
		<table class="table">
			<thead >
				<th v-for="(field, index) in this.fields">
					<div v-html="field">
						{{ field }}
					</div>
				</th>
				<tr>
			{{-- 		<td v-for="(item, index) in this.items">
						
					</td> --}}
				</tr>
			</thead>
		</table>
	</div>
</template>
<script type="text/javascript">
	export default {
	    data() {
	    	console.log(items);
	    },
	    props: {
            fields: Array,
            items: Object,
        },
	}
</script>