const getters = {
    categoryModalityWithPart(state) {
        return state.category_modality_with_part;
    },
    ParticipantsByCompetitionCategoryModality(state) {
        return state.participants_competition_category_modality;
    },
    categoryId(state) {
        return state.category_id;
    },
    categoryStatus(state) {
        return state.category_status;
    },
    modalityId(state) {
        return state.modality_id;
    },
    competition(state) {
        return state.competition;
    },
    allRoundHeats(state) {
        return state.all_round_heats;
    },
    round_heats(state) {
        return state.round_heats;
    },
    heat_scores(state) {
        return state.heat_scores;
    },
    deleteStatus(state) {
        return state.deleteStatus;
    },
    all_home_round_heats(state) {
        return state.all_home_round_heats;
    },
  };
  
  export default getters;