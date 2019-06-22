<template>
	<v-card>
	  <div>
	  	<v-card-title>
		    <v-spacer></v-spacer>
		    <v-text-field
		      v-model="search"
		      append-icon="search"
		      label="Search"
		      single-line
		      hide-details
		    ></v-text-field>
	    </v-card-title>
	    <v-data-table
	      :headers="headers"
	      :items="dataItems"
	      :pagination.sync="pagination"
	      :total-items="totalItems"
	      :loading="loading"
	      v-model="selected"
	      class="elevation-1"
	      select-all
	    >
	    	
	      <template v-slot:items="props">
	      	<td>
		        <v-checkbox
		          v-model="props.selected"
		          primary
		          hide-details
		        ></v-checkbox>
	     	 	</td>
	        <td v-for="header in headers">
	        	<p :class="header.class">{{ props.item[header.value] }}</p>
	      	</td>
	      </template>
	    </v-data-table>
	  </div>
	</v-card>
</template>
<script>
  export default {
  	data() {
      return {
      	dataItems: [],
        totalItems: 0,
  			loading: true,
  			pagination: {},
  			search:'',
      	selected: [],
      }
    },
  	props:{
  		dataItem: Array,
  		headers:Array,
  		loadingDataTable:false,
  	},
    watch: {
      params: {
        handler () {
          this.getDataFromApi()
            .then(data => {
              this.dataItems = data.items
              this.totalItems = data.total
            })
        },
        deep: true
      },
      loadingDataTable:function() {
      	if (this.loadingDataTable) {
      		this.getDataFromApi()
            .then(data => {
              this.dataItems = data.items
              this.totalItems = data.total
            })
      	}
      },
      search:function() {
      	if (this.loadingDataTable) {
      		this.getDataFromApi()
            .then(data => {
              this.dataItems = data.items
              this.totalItems = data.total
            })
      	}
      },
      selected:function() {
      	this.$emit('selectedCheckbox',this.selected)
      }
    },
    mounted () {
    	console.log('Initialize Data Table...')
      this.getDataFromApi()
        .then(data => {
          this.dataItems = data.items
          this.totalItems = data.total
        })
    },
    computed: {
        params(nv) {
            return {
                ...this.pagination,
                query: this.search
            };
        }
    },
    methods: {
      getDataFromApi () {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page, rowsPerPage } = this.pagination

          let search = this.search.trim().toLowerCase();
          let items = this.dataItem
          const total = items.length
          if (this.pagination.sortBy) {
            items = items.sort((a, b) => {
              const sortA = a[sortBy]
              const sortB = b[sortBy]

              if (descending) {
                if (sortA < sortB) return 1
                if (sortA > sortB) return -1
                return 0
              } else {
                if (sortA < sortB) return -1
                if (sortA > sortB) return 1
                return 0
              }
            })
          }

          if (search) {
              items = items.filter(item => {
                  return Object.values(item)
                      .join(",")
                      .toLowerCase()
                      .includes(search);
              });
          }

          if (rowsPerPage > 0) {
            items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
          }

          setTimeout(() => {
            this.loading = false
            resolve({
              items,
              total
            })
          }, 1000)
        })
      }
    }
  }
</script>