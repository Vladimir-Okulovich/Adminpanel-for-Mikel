<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";
  import Multiselect from "vue-multiselect";

  import { mapActions, mapGetters, mapState } from 'vuex';

	export default {
		page: {
        title: "Live Competition Management",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader,
      Multiselect
    },
    data() {
      return {
        title: "LIVE COMPETITION MANAGEMENT",
        items: [
          {
            text: "Administrator",
            href: "/admin"
          },
          {
            text: "Competition",
            href: "/admin/competition"
          },
          {
            text: "Live Management",
            active: true
          }
        ],
        categoryModality: '',
        totalRows: 1,
        currentPage: 1,
        perPage: 25,
        pageOptions: [10, 25, 50, 100],
        filter: null,
        filterOn: [],
        sortBy: "",
        sortDesc: false,
        fields: [
          { key: "name", sortable: true },
          { key: "surname", sortable: true },
          { key: "dni_ficha", sortable: true },
          { key: "birthday", sortable: true },
          { key: "club", sortable: false },
          { key: "actions", sortable: false },
        ],
        deletingId: 0,
      }
    },
    watch: {
      categoryModalityWithPart: function () {
        this.categoryModality = this.categoryModalityWithPart[0];
        this.getParticipantsByCompetitionCategoryModality({
          competitionId: this.$route.params.competitionId,
          categoryModality: this.categoryModality,
        });
      },
    },
    computed: {
      ...mapGetters([
        'categoryModalityWithPart',
        'ParticipantsByCompetitionCategoryModality',
        'categoryId',
        'modalityId',
        'categoryStatus'
      ]),
      /**
       * Total no. of records
       */
      rows() {
        return this.ParticipantsByCompetitionCategoryModality.length;
      },
      // categoryModality: function () {
      //   return this.categoryModalityWithPart[0]
      // },
    },
    mounted() {
      // Set the initial number of items
      this.totalRows = this.ParticipantsByCompetitionCategoryModality.length;
      this.getCategoryModalityWithPart(this.$route.params.competitionId);
    },
    methods: {
      ...mapActions([
        'getCategoryModalityWithPart',
        'getParticipantsByCompetitionCategoryModality',
        'unregistParticipantToCompetitionCategoryModality',
        'createFirstCompetitionBoxes',
      ]),
      /**
       * Search the table data with search input
       */
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length;
        this.currentPage = 1;
      },
      setParticipantId(id) {
        this.deletingId = id;
      },
      realDelete() {
        this.unregistParticipantToCompetitionCategoryModality({
          competitionId: this.$route.params.competitionId,
          participantId: this.deletingId,
          categoryModality: this.categoryModality,
        });
        this.$bvModal.hide('delete-modal');
      },
      categoryModalityHandler() {
        // console.log(this.categoryModality)
        if (this.categoryModality != null) {
          this.getParticipantsByCompetitionCategoryModality({
            competitionId: this.$route.params.competitionId,
            categoryModality: this.categoryModality,
          });
        }
      },
      createCompetitionBox() {
        this.createFirstCompetitionBoxes({
          competitionId: this.$route.params.competitionId,
          categoryId: this.categoryId,
          modalityId: this.modalityId,
        })
        .then(() => {
          this.$router.push({ name: 'CompetitionHeats', params: { competitionId: this.$route.params.competitionId, categoryId: this.categoryId, modalityId: this.modalityId } })
        })
      },
    }
	};
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items">
      <div class="float-right">
        <button v-if="!categoryStatus" @click="createCompetitionBox"
          class="btn btn-info btn-block d-inline-block"
        >
          Create Competition Box
        </button>
        <button v-else @click="createCompetitionBox"
          class="btn btn-info btn-block d-inline-block"
        >
          Acceder al cuadro de competición
        </button>
      </div>
    </PageHeader>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Categories and Modalities</h4>
            <multiselect 
              v-model="categoryModality"
              :options="categoryModalityWithPart"
              @input="categoryModalityHandler"
            ></multiselect>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Participants Table</h4>
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
                :items="ParticipantsByCompetitionCategoryModality"
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
                <template #cell(club)="row">
                  {{ row.item.club.name }}
                </template>
                <template #cell(actions)="row">
                  <b-button size="sm" @click="setParticipantId(row.item.id)" v-b-modal.delete-modal>
                    <i class="fas fa-user-minus"></i>
                  </b-button>
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
    <b-modal
      id="delete-modal"
      centered
      title="Delete Item"
      title-class="font-18"
      hide-footer
    >
      <p>Do you really want to delete this participant?</p>
      <footer id="delete-modal___BV_modal_footer_" class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="$bvModal.hide('delete-modal')">Cancel</button>
        <button type="button" class="btn btn-primary" @click="realDelete()">OK</button>
      </footer>
    </b-modal>
  </Layout>
</template>

<style>
  .select-field {
    text-align: center;
    padding-bottom: 15px;
  }
</style>