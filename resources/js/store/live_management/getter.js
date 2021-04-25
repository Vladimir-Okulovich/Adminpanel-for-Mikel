const getters = {
    ParticipantsByCompetitionCategoryModality(state) {
        return state.participants_competition_category_modality;
    },
    categoryId(state) {
        return state.category_id;
    },
    modalityId(state) {
        return state.modality_id;
    },
    all_round_heats(state) {
        return state.all_round_heats;
    },
    round_heats(state) {
        return state.round_heats;
    },
    heat_scores(state) {
        return state.heat_scores;
    }
  };
  
  export default getters;