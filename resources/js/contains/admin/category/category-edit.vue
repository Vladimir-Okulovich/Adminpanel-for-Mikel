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
    title: "EDIT CATEGORY",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { Layout, PageHeader },
  data() {
    return {
      title: "EDIT CATEGORY",
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
          text: "Category",
          href: "/admin/categories"
        },
        {
          text: "Edit",
          active: true
        }
      ],
      minValue: true,
      isError: false,
      Error: null,
      typeform: {
        name: "",
        description: "",
        year1: 0,
        year2: 0,
      },
      typesubmit: false,
    };
  },
  validations: {
    typeform: {
      name: { required },
      description: { required },
      year1: { required },
      year2: { required },
    }
  },
  mounted() {
    this.getCategoryById(this.$route.params.categoryId);
  },
  computed: {
    ...mapGetters([
      'getCategory'
    ]),
  },
  methods: {
    ...mapActions([
      'getCategoryById',
      'updateCategory'
    ]),
    /**
     * Validation type submit
     */
    // eslint-disable-next-line no-unused-vars
    typeForm(e) {
      this.typesubmit = true;
      this.isError = false;
      this.Error = null;
      if (this.typeform.year1 >= this.typeform.year2) {
        this.minValue = false;
      } else {
        this.minValue = true;
      }
      // stop here if form is invalid
      this.$v.$touch();
      if (!this.minValue || this.$v.typeform.name.$error || this.$v.typeform.description.$error || this.$v.typeform.year1.$error || this.$v.typeform.year2.$error) {
        return ;
      }
      return (
        this.updateCategory({
            id: this.getCategory.id,
            name: this.typeform.name,
            description: this.typeform.description,
            year1: this.typeform.year1,
            year2: this.typeform.year2,
          })
          .then((res) => {
            this.$router.push({name: "Categories"});
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
                  v-model="typeform.name=getCategory.name"
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
                    v-model="typeform.description=getCategory.description"
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
                <label>Year1</label>
                <input
                  v-model="typeform.year1=getCategory.year1"
                  type="number"
                  class="form-control"
                  placeholder="Min year"
                  name="year1"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.year1.$error }"
                />
                <div v-if="typesubmit && $v.typeform.year1.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.year1.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group">
                <label>Year2</label>
                <input
                  v-model="typeform.year2=getCategory.year2"
                  type="number"
                  class="form-control"
                  placeholder="Max year"
                  name="year2"
                  :class="{ 'is-invalid': typesubmit && ($v.typeform.year2.$error || !minValue) }"
                />
                <div v-if="typesubmit && ($v.typeform.year2.$error || !minValue)" class="invalid-feedback">
                  <span v-if="!$v.typeform.year2.required">This value is required.</span>
                  <span
                      v-if="!minValue"
                    >This value should be greater than Year1.</span>
                </div>
              </div>             
              <div class="form-group mt-5 mb-0">
                <div>
                  <button type="submit" class="btn btn-primary">Save</button>
                  <router-link to="/admin/categories" class="btn btn-secondary m-l-5 ml-1">Cancel</router-link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>