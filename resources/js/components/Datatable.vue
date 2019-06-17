<template>
	<div>
		{{ firstName }}
	</div>
</template>
<script type="text/javascript">
	export default {
	    data() {
	        return {
	            items: [{
	                age: 40,
	                first_name: 'Dickerson',
	                last_name: 'Macdonald',
	                last_name1: 'Macdonald',
	                last_name2: 'Macdonald',
	            }, {
	                age: 21,
	                first_name: 'Larsen',
	                last_name: 'Macdonald',
	                last_name1: 'Macdonald',
	                last_name2: 'Macdonald',
	            }, {
	                age: 89,
	                first_name: 'Geneva',
	                last_name: 'Macdonald',
	                last_name1: 'Macdonald',
	                last_name2: 'Macdonald',
	            }, {
	                age: 38,
	                first_name: 'Jami',
	                last_name: 'Macdonald',
	                last_name1: 'Macdonald',
	                last_name2: 'Macdonald',
	            }],
	            FirstName:this.firstName
	        }
	    },
	    props: {
            firstName: String,
            lastName: String
        },
	}
</script>