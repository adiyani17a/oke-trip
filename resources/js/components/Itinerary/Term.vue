<template>
	<div v-html="term">
	</div>
</template>
<script type="text/javascript">
    export default {
		props:{
			term:String,
		},
	}
</script>