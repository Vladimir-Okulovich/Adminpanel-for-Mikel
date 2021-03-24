<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";

  import { mapActions, mapGetters } from 'vuex';

	export default {
		page: {
        title: "MANAGE RANKING",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader
    },
    data() {
      return {
        title: "MANAGE RANKING",
        items: [
          {
            text: "Administrator",
            href: "/"
          },
          {
            text: "Manage Ranking",
            active: true
          },
        ],
        totalRows: 1,
        currentPage: 1,
        perPage: 50,
        pageOptions: [10, 25, 50, 100],
        filter: null,
        filterOn: [],
        sortBy: "",
        sortDesc: false,
        fields: [
          { label: "POSITION", key: "position", sortable: false },
          { label: "PARTICIPANT", key: "participant", sortable: false },
          { label: "3 BEST SUM", key: "3_best_sum", sortable: false },
          { label: "SOPELANA", key: "sopelana", sortable: false },
          { label: "LEKEITIO", key: "lekeitio", sortable: false },
          { label: "COPA I", key: "copa1", sortable: false },
          { label: "COPA II", key: "copa2", sortable: false },
          { label: "COPA III", key: "copa3", sortable: false },
          { label: "BEST RESULT", key: "best_result", sortable: false },
          { label: "2nd RESULT", key: "2nd_result", sortable: false },
          { label: "3rd RESULT", key: "3rd_result", sortable: false },
        ],
        deletingId: 0,
      }
    },
    computed: {
      ...mapGetters([
        'getAllRankingData'
      ]),
      /**
       * Total no. of records
       */
      rows() {
        return this.getAllRankingData.length;
      }
    },
    mounted() {
      // Set the initial number of items
      this.totalRows = this.getAllRankingData.length;
    },
    methods: {
      ...mapActions([
        '',
      ]),
      /**
       * Search the table data with search input
       */
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length;
        this.currentPage = 1;
      },
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
            <h4 class="card-title">Manage Ranking Table</h4>
            <p class="card-title-desc"></p>
            <div class="row mb-md-2">
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_length" class="dataTables_length">
                  <label class="d-inline-flex align-items-center">
                    Show
                    <b-form-select v-model="perPage" size="sm" :options="pageOptions"></b-form-select>entries
                  </label>
                </div>
              </div>
              <!-- Search -->
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_filter" class="dataTables_filter text-md-right">
                  <label class="d-inline-flex align-items-center">
                    Search:
                    <b-form-input
                      v-model="filter"
                      type="search"
                      placeholder="Search..."
                      class="form-control form-control-sm ml-2"
                    ></b-form-input>
                  </label>
                </div>
              </div>
              <!-- End search -->
            </div>
            <!-- Table -->
            <div class="table-responsive table-dark mb-0">
              <b-table
                :items="getAllRankingData"
                :fields="fields"
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
                    <b-th variant="success" colspan="11" style="color: black;text-align: center;">Cadete Male Short Boat</b-th>
                  </b-tr>
                  <b-tr>
                    <b-th variant="secondary" colspan="3" style="color: black;text-align: center;">RANKING 2021</b-th>
                    <b-th variant="primary" colspan="5" style="color: black;text-align: center;">POINTS OBTAINED ON EACH RANKING COMPETITION</b-th>
                    <b-th colspan="3"><span class="sr-only">THREE BSET RESULTS</span></b-th>
                  </b-tr>
                </template>
                <template #cell(position)="row">
                  {{ row.index }}
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
    </div>
  </Layout>
</template>