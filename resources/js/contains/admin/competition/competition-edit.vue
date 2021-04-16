<script>
import Layout from "../subcomponent/layout";
import PageHeader from "@/components/page-header";
import appConfig from "@/app.config";

import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import Switches from "vue-switches";

import { mapActions, mapGetters } from 'vuex';

import {
  required,
  email,
  minLength,
  sameAs,
  maxLength,
  minValue,
  maxValue,
  numeric,
  url,
  alphaNum
} from "vuelidate/lib/validators";

export default {
  page: {
    title: "EDIT COMPETITION",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { DatePicker, Multiselect, Switches, Layout, PageHeader },
  data() {
    return {
      title: "EDIT COMPETITION",
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
          text: "Edit",
          active: true
        }
      ],
      isError: false,
      Error: null,
      typeform: {
        title: "",
        competition_type: "",
        description: "",
        place: "",
        date: "",
        time: "",
        ranking_score: "",
        status: "",
        lycra: "",
        modality: "",
        category: "",
        logo: null,
      },
      rankingScoreOptions: [
        "Yes",
        "No"
      ],
      statusOptions: [
        "CLOSED",
        "REGISTRATION OPEN",
        "COMPETICIÓN EN CURSO"
      ],
      modalityOptions: [
        "Short Boat",
        "Long Ship"
      ],
      typesubmit: false,
    };
  },
  validations: {
    typeform: {
      title: { required },
      competition_type: { required },
      description: { required },
      place: { required },
      date: { required },
      time: { required },
      ranking_score: { required },
      status: { required },
      lycra: { required },
      modality: { required },
      category: { required },
    }
  },
  computed: {
    ...mapGetters([
      'typeOptions',
      'categoryOptions',
      'lycraOptions',
      'getCompetition',
    ]),
  },
  mounted() {
    this.getTypeOptions();
    this.getLycraOptions();
    this.getCategoryOptions();
    this.getCompetitionById(this.$route.params.competitionId);
  },
  methods: {
    ...mapActions([
      'updateCompetition',
      'getCompetitionById',
      'getTypeOptions',
      'getLycraOptions',
      'getCategoryOptions',
    ]),
    selectFile(event) {
      // `files` is always an array because the file input may be in multiple mode
      this.typeform.logo = event.target.files[0];
      // console.log(this.typeform.logo)
    },
    /**
     * Validation type submit
     */
    // eslint-disable-next-line no-unused-vars
    typeForm(e) {
      // console.log(this.typeform.status)
      this.typesubmit = true;
      this.isError = false;
      this.Error = null;
      // stop here if form is invalid
      this.$v.$touch()
      if (this.$v.typeform.title.$error || this.$v.typeform.place.$error || this.$v.typeform.date.$error || this.$v.typeform.time.$error || this.$v.typeform.description.$error || this.$v.typeform.competition_type.$error || this.$v.typeform.status.$error || this.$v.typeform.lycra.$error || this.$v.typeform.modality.$error || this.$v.typeform.category.$error) {
        return ;
      }
      return (
        this.updateCompetition({
            id: this.getCompetition.id,
            title: this.typeform.title,
            competition_type: this.typeform.competition_type,
            description: this.typeform.description,
            place: this.typeform.place,
            date: this.typeform.date,
            time: this.typeform.time,
            ranking_score: this.typeform.ranking_score,
            status: this.typeform.status,
            lycra: this.typeform.lycra,
            modality: this.typeform.modality,
            category: this.typeform.category,
            logo: this.typeform.logo,
          })
          .then((res) => {
            this.$router.push({name: "Competitions"});
            this.typesubmit = false;
          })
          .catch(error => {
            this.typesubmit = false;
            this.Error = error ? error : "";
            this.isError = true;
          })
      );
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
            <b-alert
              v-model="isError"
              variant="danger"
              class="mt-3"
              dismissible
            >{{ Error }}</b-alert>
            <form action="#" @submit.prevent="typeForm" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                    <label>Title</label>
                    <input
                      v-model="typeform.title=getCompetition.title"
                      type="text"
                      class="form-control"
                      placeholder="Competition Title"
                      name="title"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.title.$error }"
                    />
                    <div v-if="typesubmit && $v.typeform.title.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.title.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label>Competition Type</label>
                    <multiselect 
                      v-model="typeform.competition_type=getCompetition.competition_type.name" 
                      :options="typeOptions"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.competition_type.$error }"
                    ></multiselect>
                    <div v-if="typesubmit && $v.typeform.competition_type.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.competition_type.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <div>
                      <textarea
                        v-model="typeform.description=getCompetition.description"
                        class="form-control"
                        name="description"
                        :style="{ 'min-height': '100px' }"
                        :class="{ 'is-invalid': typesubmit && $v.typeform.description.$error }"
                      ></textarea>
                      <div v-if="typesubmit && $v.typeform.description.$error" class="invalid-feedback">
                        <span v-if="!$v.typeform.description.required">This value is required.</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Place</label>
                    <input
                      v-model="typeform.place=getCompetition.place"
                      type="text"
                      class="form-control"
                      placeholder="Competition Place"
                      name="place"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.place.$error }"
                    />
                    <div v-if="typesubmit && $v.typeform.place.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.place.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label>Date</label>
                    <br />
                    <date-picker
                      v-model="typeform.date=getCompetition.date"
                      format="DD-MM-YYYY"
                      value-type="format"
                      :first-day-of-week="1"
                      lang="en"
                      placeholder="dd-mm-yyyy"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.date.$error }"
                    ></date-picker>
                    <div v-if="typesubmit && $v.typeform.date.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.date.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label>Time</label>
                    <br />
                    <date-picker
                      v-model="typeform.time=getCompetition.time"
                      type="time"
                      placeholder="hh:mm:ss"
                      value-type="format"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.time.$error }"
                    ></date-picker>
                    <div v-if="typesubmit && $v.typeform.time.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.time.required">This value is required.</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  <div class="mb-3">
                    <label>Ranking_score</label>
                    <multiselect 
                      v-model="typeform.ranking_score=getCompetition.ranking_score" 
                      :options="rankingScoreOptions"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.ranking_score.$error }"
                    ></multiselect>
                    <div v-if="typesubmit && $v.typeform.ranking_score.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.ranking_score.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <multiselect 
                      v-model="typeform.status=getCompetition.status.name"
                      :options="statusOptions"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.status.$error }"
                    ></multiselect>
                    <div v-if="typesubmit && $v.typeform.status.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.status.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label>Category</label>
                    <multiselect 
                      v-model="typeform.category=getCompetition.categoryNames" 
                      :options="categoryOptions"
                      :multiple="true"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.category.$error }"
                    ></multiselect>
                    <div v-if="typesubmit && $v.typeform.category.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.category.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label>Modality</label>
                    <multiselect 
                      v-model="typeform.modality=getCompetition.modalityNames" 
                      :options="modalityOptions"
                      :multiple="true"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.modality.$error }"
                    ></multiselect>
                    <div v-if="typesubmit && $v.typeform.modality.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.modality.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label>Lycra</label>
                    <multiselect 
                      v-model="typeform.lycra=getCompetition.lycraNames" 
                      :options="lycraOptions"
                      :multiple="true"
                      :class="{ 'is-invalid': typesubmit && $v.typeform.lycra.$error }"
                    ></multiselect>
                    <div v-if="typesubmit && $v.typeform.lycra.$error" class="invalid-feedback">
                      <span v-if="!$v.typeform.lycra.required">This value is required.</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control-file" id="logo" @change="selectFile" />
                  </div>
                  <div class="form-group mt-4 mb-0">
                    <div style="float: right;">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <router-link to="/admin/competitions" class="btn btn-secondary m-l-5 ml-1">Cancel</router-link>
                      <button type="reset" class="btn btn-warning m-l-5 ml-1">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>