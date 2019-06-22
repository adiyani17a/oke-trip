<template>
	<v-card>
	  <div>
	  	<v-card-title>
        <v-select
          :items="showingPage"
          v-model="show"
          solo
          @change="$emit('callingApi',page,show)"
          style="max-width: 25%;height: 48px;"
        ></v-select>
		    <v-spacer></v-spacer>
		    <v-text-field
		      v-model="search"
		      append-icon="search"
		      label="Search"
		      single-line
		      hide-details
          style="max-width: 50%"
		    ></v-text-field>
	    </v-card-title>
	    <v-data-table
	      :headers="headers"
	      :items="dataItems"
	      :total-items="totalItems"
	      :loading="loading"
	      v-model="selected"
	      class="elevation-1"
	      select-all
        hide-actions
	    >
	      <template v-slot:items="props" >
	      	<td>
		        <v-checkbox
		          v-model="props.selected"
		          primary
		          hide-details
		        ></v-checkbox>
	     	 	</td>
	        <td v-for="header in headers" v-html='props.item[header.value]' :class="header.class">
	        	{{ props.item[header.value] }}
	      	</td>
	      </template>
	    </v-data-table>
      <template>
        <div class="text-xs-center" style="margin-top: 20px;">
          <v-pagination
            v-model="page"
            :length="4"
            circle
            @input="$emit('callingApi',page,show)"
          ></v-pagination>
        </div>
      </template>
	  </div>
	</v-card>
</template>
<script>
  export default {
  	data() {
      return {
      	dataItems: [],
        totalItems: 0,
  			search:'',
        page: 1,
      	selected: [],
        loading:true,
        showingPage: [10, 20, 50, 100, 1000],
        show: 10,
      }
    },
  	props:{
      dataItem: Array,
  		headers:Array,
  		loadingDataTable:false,
      pagination: Object,
      totalItem: 0,
  	},
    watch: {
      params: {
        handler () {
          console.log(this.pagination)
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
              console.log('Loading Datatable Complete...')
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
          const total = this.totalItem
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
      },
    }
  }
</script>