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
      }
    },
    watch: {
      
    },
    computed: {
      ...mapGetters([
        'all_round_heats',
        'lycraColorOptions',
      ]),
    },
    mounted() {
      this.competitionId = this.$route.params.competitionId;
      this.categoryId = this.$route.params.categoryId;
      this.modalityId = this.$route.params.modalityId;
      this.initCompetitionHeats({
        competitionId: this.competitionId,
        categoryId: this.categoryId,
        modalityId: this.modalityId,
      });
      this.getLycraOptions();
    },
    methods: {
      ...mapActions([
        'initCompetitionHeats',
        'getLycraOptions',
        'setProgressStatus'
      ]),
      heatDetailsGo(round, heat) {
        this.setProgressStatus({
          competitionId: this.competitionId,
          categoryId: this.categoryId,
          modalityId: this.modalityId,
          round: round,
          heat: heat,
        })
        .then(() => {
          this.$router.push({ name: 'CompetitionHeatDetails', params: {competitionId: this.competitionId, categoryId: this.categoryId, modalityId: this.modalityId, round: round, heat: heat} })
        }) 
      },
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
        <h4 class="mb-0 text-center" style="border-bottom: 1px solid #64676f;padding: 5px 20px;">{{ all_round_heats[0][0][0].com_cat_mod_participant.competition.title }}</h4>
        <p class="mb-0" style="border-bottom: 1px solid #64676f;padding: 3px 20px;">{{ all_round_heats[0][0][0].com_cat_mod_participant.competition.description }}</p>
        <p class="mb-0" style="border-bottom: 1px solid #64676f;padding: 3px 20px;">
          Lekua, data eta ordua:
          {{ all_round_heats[0][0][0].com_cat_mod_participant.competition.place }}
          {{ all_round_heats[0][0][0].com_cat_mod_participant.competition.date }}
          {{ all_round_heats[0][0][0].com_cat_mod_participant.competition.time }}
        </p>
        <p class="mb-0" style="padding: 3px 20px;">Antolatzailea: {{ all_round_heats[0][0][0].com_cat_mod_participant.competition.organizer }}</p>
      </div>
    </div>

    <div class="text-center w-100 mt-4">
      <h4 style="background: #32394e;padding: 10px 0;">
        {{ all_round_heats[0][0][0].com_cat_mod_participant.category.name }}
        {{ all_round_heats[0][0][0].com_cat_mod_participant.category.sex.name }}
        {{ all_round_heats[0][0][0].com_cat_mod_participant.modality.name }}
      </h4>
    </div>

    <div class="row" v-for="(round, round_index) in all_round_heats" :key="round_index">
      <h4 class="my-4 col-12">ROUND {{ round_index+1 }}</h4>
      <div class="col-lg-4 col-md-6 col-sm-6" v-for="(heat, heat_index) in round" :key="heat_index">
        <div class="table-responsive mb-0">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="4" style="color: black;background: #b8e6e2;cursor: pointer;" @click="heatDetailsGo(round_index+1, heat_index+1)">
                  ROUND {{ round_index+1 }} HEAT {{ heat_index+1 }}
                </th>
              </tr>
              <tr class="thead-light">
                <th></th>
                <th>Participant</th>
                <th>Points</th>
                <th>Position</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(round_heat, round_heat_index) in heat" :key="round_heat_index">
                <th scope="row" v-bind:style="{ background: lycraColorOptions[round_heat_index] }"></th>
                <td>{{ round_heat.com_cat_mod_participant.participant.name+' '+round_heat.com_cat_mod_participant.participant.surname }}</td>
                <td>{{ round_heat.points }}</td>
                <td>{{ round_heat.position }}</td>
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