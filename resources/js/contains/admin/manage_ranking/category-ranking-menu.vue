<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";
  import Multiselect from "vue-multiselect";

  import { mapActions, mapGetters } from 'vuex';
import categoryCreateVue from '../category/category-create.vue';

	export default {
		page: {
        title: "CLASIFICACIONES RANKING",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader,
      Multiselect
    },
    data() {
      return {
        title: "CLASIFICACIONES RANKING",
        items: [
          {
            text: "Home",
            href: "/admin/competitions"
          },
          {
            text: "Clasificaciones Ranking",
            active: true
          }
        ],
        categoryModality: "",
        totalRows: 1,
        currentPage: 1,
        perPage: 50,
        pageOptions: [10, 25, 50, 100],
        filter: null,
        filterOn: [],
        sortBy: "",
        sortDesc: false,
        // fields: [
        //   { label: "POSITION", key: "position", sortable: false },
        //   { label: "PARTICIPANT", key: "participant", sortable: false },
        //   { label: "3 BEST SUM", key: "3_best_sum", sortable: false },
        //   { label: "SOPELANA", key: "sopelana", sortable: false },
        //   { label: "LEKEITIO", key: "lekeitio", sortable: false },
        //   { label: "COPA I", key: "copa1", sortable: false },
        //   { label: "COPA II", key: "copa2", sortable: false },
        //   { label: "COPA III", key: "copa3", sortable: false },
        //   { label: "BEST RESULT", key: "best_result", sortable: false },
        //   { label: "2nd RESULT", key: "2nd_result", sortable: false },
        //   { label: "3rd RESULT", key: "3rd_result", sortable: false },
        // ],
      }
    },
    watch: {
      getAllCategoryModality: function () {
        this.categoryModality = this.getAllCategoryModality[0];
        this.getCategoryRankingPoints({
          categoryModality: this.categoryModality,
        });
      },
    },
    computed: {
      ...mapGetters([
        'getAllCategoryModality',
        'categoryRankingPoints',
        'competitionNumber',
      ]),
      /**
       * Total no. of records
       */
      rows() {
        return this.categoryRankingPoints.length;
      }
    },
    mounted() {
      // Set the initial number of items
      this.totalRows = this.categoryRankingPoints.length;
      this.initRankingMenu();
    },
    methods: {
      ...mapActions([
        'initRankingMenu',
        'getCategoryRankingPoints',
      ]),
      /**
       * Search the table data with search input
       */
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length;
        this.currentPage = 1;
      },
      categoryModalityHandler() {
        this.getCategoryRankingPoints({
          categoryModality: this.categoryModality,
        });
      }
    }
	};
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Seleccionar Categoría</h4>
            <multiselect 
              v-model="categoryModality"
              deselect-label=""
              :options="getAllCategoryModality"
              @input="categoryModalityHandler"
            ></multiselect>
          </div>
        </div>

        <div id="">
          <h4 class="card-title mb-4">Ranking Categoría "{{ categoryModality }}"</h4>
          <div class="row mb-md-2">
            <div class="col-sm-12 col-md-6">
              <div id="tickets-table_length" class="dataTables_length">
                <label class="d-inline-flex align-items-center">
                  Mostrar 
                  <b-form-select v-model="perPage" size="sm" :options="pageOptions"></b-form-select> registros
                </label>
              </div>
            </div>
            <!-- Search -->
            <div class="col-sm-12 col-md-6">
              <div id="tickets-table_filter" class="dataTables_filter text-md-right">
                <label class="d-inline-flex align-items-center">
                  Buscar:
                  <b-form-input
                    v-model="filter"
                    type="search"
                    placeholder="Buscar..."
                    class="form-control form-control-sm ml-2"
                  ></b-form-input>
                </label>
              </div>
            </div>
            <!-- End search -->
          </div>
          <!-- Table -->
          <div class="table-responsive table-bordered table-dark ranking-table mb-0">
            <b-table
              :items="categoryRankingPoints"
              responsive="sm"
              :per-page="perPage"
              :current-page="currentPage"
              :sort-by.sync="sortBy"
              :sort-desc.sync="sortDesc"
              :filter="filter"
              :filter-included-fields="filterOn"
              @filtered="onFiltered"
            >
              <template #thead-top="data">
                <b-tr>
                  <b-th variant="success" :colspan="competitionNumber+6" style="color: black;text-align: center;font-size: 18px;">{{ categoryModality }}</b-th>
                </b-tr>
                <b-tr>
                  <b-th  colspan="3" style="background: white;color: black;text-align: center;">RANKING 2021</b-th>
				          <b-th variant="primary" :colspan="competitionNumber" style="color: black;text-align: center;">COMPETICIONES PUNTUABLES</b-th>
                  <b-th variant="pink" colspan="3" style="color: black;text-align: center;">TRES MEJORES</b-th>
                </b-tr>
              </template>
            </b-table>
          </div>
          <div class="row">
            <div class="col">
              <div class="dataTables_paginate paging_simple_numbers float-right">
                <ul class="pagination pagination-rounded mb-0">
                  <!-- pagination -->
                  <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage"></b-pagination>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<style scoped>

</style>