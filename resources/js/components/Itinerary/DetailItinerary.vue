<template>
	<div>
		<v-tabs
      v-model="active"
      color="cyan"
      dark
      slider-color="yellow"
    >
      <v-tab
        v-for="(item,index) in tabs"
        :key="index"
        ripple
       >
        {{ item.title }}

      </v-tab>
      <v-tab-item
        v-for="(item,index) in tabs"
        :key="index"
        >
        <v-card flat>
          <v-layout wrap>
            <v-flex xs12 md6 style="padding: 10px">
              <v-select
                v-model="tourLeader"
                label="Destination*"
                :items="tourLeaderOptions"
                item-text="name"
                item-value="id"
                multiple
                @blur="$v.tourLeader.$touch()"
                :error-messages="tourLeaderErrors"
                >
              </v-select>
            </v-flex>
            <v-flex xs12 md6 style="padding: 10px">
              <h5>Upload Final File</h5>
              <vue-dropify id="final_file" :multiple="false" ref="final" message="Upload Data By Click Here"></vue-dropify> 
            </v-flex>
            <v-flex xs12 md6 style="padding: 10px">
              <h5>Upload Tata Tertib</h5>
              <vue-dropify id="tata_tertib" :multiple="false" ref="tataTertib" message="Upload Data By Click Here"></vue-dropify> 
            </v-flex>
          </v-layout>                
        </v-card>
      </v-tab-item>
    </v-tabs>
	</div>
</template>
<script type="text/javascript">
  import { required, maxLength, email } from 'vuelidate/lib/validators'
  import VueDropify from 'vue-dropify';
  export default {
      data() {
          return {
              tabs: [{
                  title: 'Form Data'
              }, {
                  title: 'Itinerary Report'
              }],
              active: null,
              tourLeader:'',
              validations: {
                  tourLeader: {
                      required
                  },
              },
              tourLeaderOptions: [{
                name:""
              }]
          }
      },
      components: {
          'vue-dropify': VueDropify
      },
      methods: {
          next() {
              const active = parseInt(this.active)
              this.active = (active < 2 ? active + 1 : 0)
          }
      },
      computed: {
          tourLeaderErrors() {
              const errors = []
              if (!this.$v.name.required) {
                  errors.push('Name is required.');
                  return errors;
              }
          },
      }
  }
</script>