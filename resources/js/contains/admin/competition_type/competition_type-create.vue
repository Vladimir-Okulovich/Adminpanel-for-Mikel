<script>
import Layout from "../subcomponent/layout";
import PageHeader from "@/components/page-header";
import appConfig from "@/app.config";

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
    title: "ADD COMPETITION TYPE",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { Layout, PageHeader },
  data() {
    return {
      title: "ADD COMPETITION TYPE",
      items: [
        {
          text: "Administrator",
          href: "/"
        },
        {
          text: "Competition Data",
          active: true
        },
        {
          text: "Competition Type",
          href: "/admin/competition_types"
        },
        {
          text: "Add",
          active: true
        }
      ],
      isError: false,
      Error: null,
      typeform: {
        name: "",
        description: "",
      },
      typesubmit: false,
    };
  },
  validations: {
    typeform: {
      name: { required },
      description: { required },
    }
  },
  methods: {
    ...mapActions([
        'createCompetitionType'
      ]),
    /**
     * Validation type submit
     */
    // eslint-disable-next-line no-unused-vars
    typeForm(e) {
      this.typesubmit = true;
      this.isError = false;
      this.Error = null;
      // stop here if form is invalid
      this.$v.$touch()
      if (this.$v.typeform.name.$error || this.$v.typeform.description.$error) {
        return ;
      }
      return (
        this.createCompetitionType({
            name: this.typeform.name,
            description: this.typeform.description
          })
          .then((res) => {
            this.$router.push({name: "CompetitionTypes"});
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
            <form action="#" @submit.prevent="typeForm">
              <div class="form-group">
                <label>Name</label>
                <input
                  v-model="typeform.name"
                  type="text"
                  class="form-control"
                  placeholder="Name"
                  name="name"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.name.$error }"
                />
                <div v-if="typesubmit && $v.typeform.name.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.name.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <div>
                  <textarea
                    v-model="typeform.description"
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
              <div class="form-group mt-5 mb-0">
                <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <router-link to="/admin/competition_types" class="btn btn-secondary m-l-5 ml-1">Cancel</router-link>
                  <button type="reset" class="btn btn-warning m-l-5 ml-1">Reset</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>