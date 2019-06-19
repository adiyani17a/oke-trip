<template>
	<div v-if="this.api !== null" class="ui container">
		<filter-bar></filter-bar>
		<vuetable ref="vuetable"
			:api-url="api"
			:fields="fields"
			pagination-path="" 
		    :css="css.table"
			@vuetable:pagination-data="onPaginationData"
		></vuetable>
		<div class="vuetable-pagination ui basic segment grid">
			<vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>
			<vuetable-pagination ref="pagination"
								 @vuetable-pagination:change-page="onChangePage"
								 :css="css.pagination">
			</vuetable-pagination>	
		</div>
	</div>
</template>

<script>
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import accounting from 'accounting'
import moment from 'moment'
import FilterBar from './FilterBar'
	export default {
	    components: {
	        Vuetable,
	        VuetablePaginationInfo,
	        FilterBar,
	        VuetablePagination
	    },
	    data() {
	        return {
	            css: {
	                table: {
	                    tableClass: 'table table-striped table-bordered table-hovered',
	                    loadingClass: 'loading',
	                    ascendingIcon: 'fas fa-arrow-up',
	                    descendingIcon: 'fas fa-arrow-down',
	                    handleIcon: 'fas fa-arrow-down'
	                },
	                pagination: {
	                    infoClass: 'pull-left',
	                    wrapperClass: 'vuetable-pagination pull-right',
	                    activeClass: 'btn-primary text-light',
	                    disabledClass: 'disabled',
	                    pageClass: 'btn btn-border',
	                    linkClass: 'btn btn-border',
	                    icons: {
	                        first: '',
	                        prev: '',
	                        next: '',
	                        last: '',
	                    },
	                }
	            }
	        }
	    },
	    props: {
	        fields: Array,
	        dataItems: Object,
	        api: String,
	    },
	    methods: {
	        allcap(value) {
	            return value.toUpperCase()
	        },
	        genderLabel(value) {
	            return value == 'M' ?
	                '<span class="badge badge-primary">Male</span>' :
	                '<span class="badge badge-danger">Female</span>'
	        },
	        formatNumber(value) {
	            return accounting.formatNumber(value, 2)
	        },
	        formatDate(value, fmt = 'D MMM YYYY') {
	            return (value == null) ?
	                '' :
	                moment(value, 'YYYY-MM-DD').format(fmt)
	        },
	        onPaginationData(paginationData) {
	            this.$refs.pagination.setPaginationData(paginationData)
	        },
	        onChangePage(page) {
	            this.$refs.vuetable.changePage(page)
	        },
	        onPaginationData(paginationData) {
	            this.$refs.pagination.setPaginationData(paginationData)
	            this.$refs.paginationInfo.setPaginationData(paginationData) // <----
	        },
	    }
	}
</script>