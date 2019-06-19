<template>	
	<div class="col-md-12">
		<div style="width: 40%;float: right;margin-bottom: 20px">
			Search&nbsp;
			<input type="text" v-model="paramSearchBox" class="form-control" style="width: 86%;display: inline-block;" :placeholder="placeholder" @keyup="searchBox">
		</div>
	</div>
</template>	

<script type="text/javascript">
	export default{
		data(){
			return{
				paramSearchBox:''
			}
		},
		props: {
	        placeholder: String,

	    },
	    methods:{
	    	searchBox(){
	    		this.$emit('keyupSearchinBox', this.paramSearchBox);
	    	}
	    }
	}
</script>