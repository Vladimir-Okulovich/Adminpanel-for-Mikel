import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.SET_ALL_COMPETITION] (state, data) {
    state.competitions = data.competitions;
  },
  [type.SET_COMPETITION] (state, data) {
    state.competition = data.competition;
  },
};
export default mutations;