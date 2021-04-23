<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";

  import { mapActions, mapGetters } from 'vuex';

	export default {
		page: {
        title: "Competition Heats",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader,
    },
    data() {
      return {
        competitionId: 0,
        categoryId: 0,
        modalityId: 0,
        round: 0,
        heat: 0,
      }
    },
    watch: {
      
    },
    computed: {
      ...mapGetters([
        'round_heats',
        'lycraColorOptions',
      ]),
    },
    mounted() {
      this.competitionId = this.$route.params.competitionId;
      this.categoryId = this.$route.params.categoryId;
      this.modalityId = this.$route.params.modalityId;
      this.round = this.$route.params.round;
      this.heat = this.$route.params.heat;
      this.initHeatDetails({
        competitionId: this.competitionId,
        categoryId: this.categoryId,
        modalityId: this.modalityId,
        round: this.round,
        heat: this.heat,
      });
      this.getLycraOptions();
    },
    methods: {
      ...mapActions([
        'initHeatDetails',
        'getLycraOptions',
      ]),
      // this.$router.go(-1)
      // window.location.reload()
    }
	};
</script>
<template>
  <Layout>
    <div class="d-flex justify-content-center pt-4">
      <b-img
        :src="'/images/logo.png'"
        height="127"
        alt="logo"
      ></b-img>
      <div class="w-50" style="border: 1px solid #64676f;">
        <h4 class="mb-0 text-center" style="border-bottom: 1px solid #64676f;padding: 5px 20px;">{{ round_heats[0].com_cat_mod_participant.competition.title }}</h4>
        <p class="mb-0" style="border-bottom: 1px solid #64676f;padding: 3px 20px;">{{ round_heats[0].com_cat_mod_participant.competition.description }}</p>
        <p class="mb-0" style="border-bottom: 1px solid #64676f;padding: 3px 20px;">
          Lekua, data eta ordua:
          {{ round_heats[0].com_cat_mod_participant.competition.place }}
          {{ round_heats[0].com_cat_mod_participant.competition.date }}
          {{ round_heats[0].com_cat_mod_participant.competition.time }}
        </p>
        <p class="mb-0" style="padding: 3px 20px;">Antolatzailea: {{ round_heats[0].com_cat_mod_participant.competition.organizer }}</p>
      </div>
    </div>

    <div class="text-center w-100 mt-4">
      <h4 style="background: #32394e;padding: 10px 0;">
        {{ round_heats[0].com_cat_mod_participant.category.name }}
        {{ round_heats[0].com_cat_mod_participant.category.sex.name }}
        {{ round_heats[0].com_cat_mod_participant.modality.name }}
        <span style="font-size: 16px;">(Round {{ round }} Heat {{ heat }})</span>
      </h4>
    </div>

    <div class="row">
      <div class="col-lg-6 col-md-9 col-sm-12">
        <div class="table-responsive mb-0">
          <table class="table table-bordered">
            <thead>
              <tr class="thead-light">
                <th>LYCRA</th>
                <th>PARTICIPANT</th>
                <th>POSITION</th>
                <th>1st Best Wave</th>
                <th>2nd Best Wave</th>
                <th>SUM</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(round_heat, round_heat_index) in round_heats" :key="round_heat_index">
                <th scope="row" v-bind:style="{ background: lycraColorOptions[round_heat_index] }"></th>
                <td>{{ round_heat.com_cat_mod_participant.participant.name+' '+round_heat.com_cat_mod_participant.participant.surname }}</td>
                <td>{{ round_heat.position }}</td>
                <td>{{ round_heat.first_score }}</td>
                <td>{{ round_heat.second_score }}</td>
                <td>{{ round_heat.points }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-12">
        <div class="table-responsive mb-0">
          <table class="table table-bordered">
            <thead>
              <tr class="thead-light">
                <th>LYCRA</th>
                <th>PARTICIPANT</th>
                <th>POSITION</th>
                <th>1st Best Wave</th>
                <th>2nd Best Wave</th>
                <th>SUM</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(round_heat, round_heat_index) in round_heats" :key="round_heat_index">
                <th scope="row" v-bind:style="{ background: lycraColorOptions[round_heat_index] }"></th>
                <td>{{ round_heat.com_cat_mod_participant.participant.name+' '+round_heat.com_cat_mod_participant.participant.surname }}</td>
                <td>{{ round_heat.position }}</td>
                <td>{{ round_heat.first_score }}</td>
                <td>{{ round_heat.second_score }}</td>
                <td>{{ round_heat.points }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </Layout>
</template>

<style>
</style>