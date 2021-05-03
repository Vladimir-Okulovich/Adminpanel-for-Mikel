const getters = {
    judge_round_heats(state) {
        return state.judge_round_heats;
    },
    judge_heat_scores(state) {
        return state.judge_heat_scores;
    },
    isFirst(state) {
    	return state.isFirst;
    },
};

export default getters;