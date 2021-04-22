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
  };
  
  export default getters;