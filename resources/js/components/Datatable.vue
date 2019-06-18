<template>
	<div class="ui container">
		<vuetable ref="vuetable"
			api-url="https://vuetable.ratiw.net/api/users"
			:fields="fields"
			pagination-path="" 
			@vuetable:pagination-data="onPaginationData"
		></vuetable>
		<vuetable-pagination ref="pagination"
							 @vuetable-pagination:change-page="onChangePage"
							 :css="css.pagination">
		</vuetable-pagination>
	</div>
</template>

<script>
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import accounting from 'accounting'
import moment from 'moment'
	export default {
	    components: {
	        Vuetable,
	        VuetablePagination
	    },
	    data() {
	        return {
	            fields: [
	                //...
	                {
	                    name: 'nickname',
	                    callback: 'allcap'
	                }, {
	                    name: 'salary',
	                    titleClass: 'center aligned',
	                    dataClass: 'right aligned',
	                    callback: 'formatNumber'
	                }, {
	                    name: 'gender',
	                    titleClass: 'center aligned',
	                    dataClass: 'center aligned',
	                    callback: 'genderLabel'
	                }, {
	                    name: 'birthdate',
	                    titleClass: 'center aligned',
	                    dataClass: 'center aligned',
	                    callback: 'formatDate|DD-MM-YYYY'
	                },
	                //...
	            ],
	            css: {
	                table: {
	                    tableClass: 'table table-striped table-bordered table-hovered',
	                    loadingClass: 'loading',
	                    ascendingIcon: 'glyphicon glyphicon-chevron-up',
	                    descendingIcon: 'glyphicon glyphicon-chevron-down',
	                    handleIcon: 'glyphicon glyphicon-menu-hamburger',
	                },
	                pagination: {
	                    infoClass: 'pull-left',
	                    wrapperClass: 'vuetable-pagination pull-right',
	                    activeClass: 'btn-primary',
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
	        }
	    }
	}
</script>