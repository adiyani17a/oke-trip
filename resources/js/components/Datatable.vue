<template id="datatable">
	<v-card>
	  <div >
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
        :pagination.sync="pagination"
	      :total-items="totalItems"
	      :loading="loading"
	      v-model="selected"
	      class="elevation-1"
        item-key="id"
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
	        <td v-for="header in headers" :class="header.class" >
            <div v-if="header.type == 'link-badge'">
              <v-badge color="orange">
                <template v-slot:badge>
                 2
                </template>
                <span>
                  <a :href="header.url+header.urlAdder+'/'+props.item[header.value]">{{ props.item[header.value] }}</a>
                </span>
              </v-badge>
            </div>
            <div v-if="header.type == 'image'" class="text-xs-center">
              <div v-if="props.item[header.value] != null">
                <v-img :src="props.item[header.value]" aspect-ratio="1.7"></v-img>
              </div>
            </div>
            <div v-if="header.type == 'switch'" class="text-xs-center">
              <v-switch  @change="switchChange(dataItem[props.index][header.value],props.item.id,header.value)" v-model="dataItem[props.index][header.value]" style="margin-left: 35px;margin-top: 15px;" class="text-xs-center">
              </v-switch>
            </div>
            <div v-if="header.type == 'currency'" class="text-xs-center">
              {{ props.item[header.value] | currency}}
            </div>
            <div v-if="header.type == 'hot deals'" class="text-xs-center">
              <v-btn color="primary" text-color="white" v-if="props.item[header.value] == 'Y'" @click="hotDeals('N',props.item.id)">Hot Deals</v-btn>
              <v-btn color="warning" text-color="white" v-if="props.item[header.value] == 'N'" @click="hotDeals('Y',props.item.id)">Not Hot Deals</v-btn>
            </div>
            <div v-if="header.type == 'default' || header.type == undefined">
              {{ props.item[header.value] }}
            </div>
            <div v-if="header.type == 'label'">
              <v-chip :color="props.item.color" class="text-white">{{ props.item[header.value] }}</v-chip>
            </div>
	      	</td>
	      </template>
	    </v-data-table>
      <template>
        <div class="text-xs-center" style="margin-top: 20px;" >
          <v-pagination
            v-model="page"
            :length.sync="this.paginations.total"
            circle
            :total-visible="12"
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
  			pagination:{},
        page: 1,
      	selected: ['true'],
        loading:true,
        showingPage: [10, 20, 50, 100, 1000],
        show: 10,
        switching:[] = [],
      }
    },
  	props:{
      dataItem: Array,
  		headers:Array,
  		loadingDataTable:false,
      paginations: Object,
      totalItem: 0,
  	},
    watch: {
      pagination:function() {
          this.getDataFromApi()
            .then(data => {
              this.dataItems = data.items
              this.totalItems = data.total
            })
        deep: true
      },
      loadingDataTable:function() {
        this.pagination.current = this.paginations.current
        this.pagination.total = this.paginations.total
        this.pagination.rowsPerPage = this.paginations.rowsPerPage
        this.pagination.totalItems = this.paginations.totalItems
      	if (this.loadingDataTable) {
      		this.getDataFromApi()
            .then(data => {
              this.dataItems = data.items
              this.totalItems = data.total

              this.$emit('getCurrentPage',this.page)
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

      Vue.filter('currency', function(val){
          return accounting.formatNumber(val)
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
          this.switching = this.dataItem
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
      switchChange(data,id,param){
        this.$emit('switchChange',data,id,param);
      },
      checkboxChange(data,id){
        this.$emit('checkboxChange',data.id)
      },
      hotDeals(param,id){
        this.$emit('hotDeals',param,id)
      }
    }
  }
</script>