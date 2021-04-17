<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";
  import Multiselect from "vue-multiselect";

  import { mapActions, mapGetters } from 'vuex';

	export default {
		page: {
        title: "REGIST PARTICIPANT TO COMPETITION",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader,
      Multiselect
    },
    data() {
      return {
        title: "REGIST PARTICIPANT TO COMPETITION",
        items: [
          {
            text: "Administrator",
            href: "/admin"
          },
          {
            text: "Competition",
            href: "/admin/competitions"
          },
          {
            text: "Regist Participant",
            active: true,
          },
        ],
        totalRows_1: 1,
        currentPage_1: 1,
        perPage_1: 10,
        pageOptions: [10, 25, 50, 100],
        filter_1: null,
        filterOn_1: [],
        sortBy: "surname",
        sortDesc: false,
        fields: [
          { key: "name", sortable: true },
          { key: "surname", sortable: true },
          { key: "sex", sortable: false },
          { key: "birthday", sortable: true },
          { key: "dni_ficha", sortable: false },
          { key: "club", sortable: false },
          { key: "actions", sortable: false },
        ],
        totalRows_2: 1,
        currentPage_2: 1,
        perPage_2: 10,
        filter_2: null,
        filterOn_2: [],
        isRequiredModality: {
          register: true,
          edit: true,
        },
        modalityOptions: [
          "Short Boat",
          "Long Ship",
        ],
        register_modalities: [
          "Short Boat",
          "Long Ship",
        ],
        edit_modalities: [],
        participantId: 0,
      }
    },
    computed: {
      ...mapGetters([
        'getRegisteredParticipants',
        'getNonRegisteredParticipants',
      ]),
      /**
       * Total no. of records
       */
      rows_1() {
        return this.getRegisteredParticipants.length;
      },
      rows_2() {
        return this.getNonRegisteredParticipants.length;
      },
    },
    mounted() {
      // Set the initial number of items
      this.totalRows_1 = this.getRegisteredParticipants.length;
      this.totalRows_2 = this.getNonRegisteredParticipants.length;
      this.initParticipantsForCompetition(this.$route.params.competitionId);
    },
    methods: {
      ...mapActions([
        'initParticipantsForCompetition',
        'registParticipantToCompetition',
        'updateParticipantToCompetition',
        'unregistParticipantToCompetition',
        'getModalityOfParticipant',
      ]),
      /**
       * Search the table data with search input
       */
      onFiltered_1(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows_1 = filteredItems.length;
        this.currentPage_1 = 1;
      },
      onFiltered_2(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows_2 = filteredItems.length;
        this.currentPage_2 = 1;
      },
      setParticipantId(id) {
        this.participantId = id;
      },
      getModalityOfParticipantIcon(id) {
        this.setParticipantId(id);
        this.getModalityOfParticipant({
          competitionId: this.$route.params.competitionId,
          participantId: id,
        })
        .then((res) => {
          // console.log(res)
          this.edit_modalities = res.data.modality_participant;
        })
      },
      registerParticipantWithModality() {
        // console.log(this.modalities.length)
        if (this.register_modalities.length > 0) {
          this.isRequiredModality.register = true;
          this.registParticipantToCompetition({
            competitionId: this.$route.params.competitionId,
            participantId: this.participantId,
            modality: this.register_modalities,
          });
          this.$bvModal.hide('register-modality-modal');
        } else {
          this.isRequiredModality.register = false;
        }
      },
      editParticipantWithModality() {
        // console.log(this.modalities.length)
        if (this.edit_modalities.length > 0) {
          this.isRequiredModality.edit = true;
          this.updateParticipantToCompetition({
            competitionId: this.$route.params.competitionId,
            participantId: this.participantId,
            modality: this.edit_modalities,
          });
          this.$bvModal.hide('edit-modality-modal');
        } else {
          this.isRequiredModality.edit = false;
        }
      },
      unregisterParticipant() {
        this.unregistParticipantToCompetition({
          competitionId: this.$route.params.competitionId,
          participantId: this.participantId,
        });
        this.$bvModal.hide('unregister-modality-modal');
      }
    }
	};
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items">
      <div class="float-right">
        <router-link :to="{ name: 'CompetitionParticipantAdd', params: { competitionId: this.$route.params.competitionId } }"
          class="btn btn-info btn-block d-inline-block"
        >
          <i class="fas fa-plus mr-1"></i> ADD PARTICIPANT
        </router-link>
      </div>
    </PageHeader>

    <div class="row">
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Non-Registered Participants Table</h4>
            <p class="card-title-desc"></p>
            <div class="row mb-md-2">
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_length" class="dataTables_length">
                  <label class="d-inline-flex align-items-center">
                    Show
                    <b-form-select v-model="perPage_1" size="sm" :options="pageOptions"></b-form-select>entries
                  </label>
                </div>
              </div>
              <!-- Search -->
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_filter" class="dataTables_filter text-md-right">
                  <label class="d-inline-flex align-items-center">
                    Search:
                    <b-form-input
                      v-model="filter_1"
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
                :items="getNonRegisteredParticipants"
                :fields="fields"
                responsive="sm"
                :per-page="perPage_1"
                :current-page="currentPage_1"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :filter="filter_1"
                :filter-included-fields="filterOn_1"
                @filtered="onFiltered_1"
              >
                <template #cell(sex)="row">
                  {{ row.item.sex.name }}
                </template>
                <template #cell(club)="row">
                  {{ row.item.club.name }}
                </template>
                <template #cell(actions)="row">
                  <b-button size="sm" @click="setParticipantId(row.item.id)" v-b-modal.register-modality-modal>
                    <i class="fas fa-user-plus"></i>
                  </b-button>
                </template>
              </b-table>
            </div>
            <div class="row">
              <div class="col">
                <div class="dataTables_paginate paging_simple_numbers float-right">
                  <ul class="pagination pagination-rounded mb-0">
                    <!-- pagination -->
                    <b-pagination v-model="currentPage_1" :total-rows="rows_1" :per-page="perPage_1"></b-pagination>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Registered Participants Table</h4>
            <p class="card-title-desc"></p>
            <div class="row mb-md-2">
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_length" class="dataTables_length">
                  <label class="d-inline-flex align-items-center">
                    Show
                    <b-form-select v-model="perPage_2" size="sm" :options="pageOptions"></b-form-select>entries
                  </label>
                </div>
              </div>
              <!-- Search -->
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_filter" class="dataTables_filter text-md-right">
                  <label class="d-inline-flex align-items-center">
                    Search:
                    <b-form-input
                      v-model="filter_2"
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
                :items="getRegisteredParticipants"
                :fields="fields"
                responsive="sm"
                :per-page="perPage_2"
                :current-page="currentPage_2"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :filter="filter_2"
                :filter-included-fields="filterOn_2"
                @filtered="onFiltered_2"
              >
                <template #cell(sex)="row">
                  {{ row.item.sex.name }}
                </template>
                <template #cell(club)="row">
                  {{ row.item.club.name }}
                </template>
                <template #cell(actions)="row">
                  <b-button size="sm" @click="getModalityOfParticipantIcon(row.item.id)" v-b-modal.edit-modality-modal>
                    <i class="fas fa-user-edit"></i>
                  </b-button>
                  <b-button size="sm" @click="setParticipantId(row.item.id)" v-b-modal.unregister-modality-modal>
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
                    <b-pagination v-model="currentPage_2" :total-rows="rows_2" :per-page="perPage_2"></b-pagination>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-modal
      id="register-modality-modal"
      centered
      title="Select Modality"
      title-class="font-18"
      hide-footer
    >
      <div class="">
        <label>Modality</label>
        <multiselect 
          v-model="register_modalities"
          :options="modalityOptions"
          :multiple="true"
        ></multiselect>
        <div class="invalid-feedback" :class="{ 'd-inline-block': !isRequiredModality.register }">
          <span>This value is required.</span>
        </div>
      </div>
      <footer class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="$bvModal.hide('register-modality-modal')">Cancel</button>
        <button type="button" class="btn btn-primary" @click="registerParticipantWithModality()">Register</button>
      </footer>
    </b-modal>

    <b-modal
      id="edit-modality-modal"
      centered
      title="Update Modality"
      title-class="font-18"
      hide-footer
    >
      <div class="">
        <label>Modality</label>
        <multiselect 
          v-model="edit_modalities"
          :options="modalityOptions"
          :multiple="true"
        ></multiselect>
        <div class="invalid-feedback" :class="{ 'd-inline-block': !isRequiredModality.edit }">
          <span>This value is required.</span>
        </div>
      </div>
      <footer class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="$bvModal.hide('edit-modality-modal')">Cancel</button>
        <button type="button" class="btn btn-primary" @click="editParticipantWithModality()">Update</button>
      </footer>
    </b-modal>

    <b-modal
      id="unregister-modality-modal"
      centered
      title="Unregister Participant"
      title-class="font-18"
      hide-footer
    >
      <p>Are you sure you want to unregister selected participant?</p>
      <footer class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="$bvModal.hide('unregister-modality-modal')">Cancel</button>
        <button type="button" class="btn btn-primary" @click="unregisterParticipant()">Unregister</button>
      </footer>
    </b-modal>
  </Layout>
</template>