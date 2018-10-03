import {cities} from '../api/area'

export default {
  data () {
    return {
      provinces: [],
      cities: [],
      counties: [],
      streets: [],
      locked: false
    }
  },
  methods: {
    async getCities (provicenId) {
      if (!provicenId) {
        return this.cities
      }
      let data = this.$store.getters.getCities(provicenId)
      this.cities = data
      return data
    },
    async getCountie (cityId) {
      if (!cityId) {
        return this.cities
      }
      let {data} = await cities(cityId, 3)
      this.counties = data
      return data
    },
    async getStreets (countyId) {
      if (!countyId) {
        return this.counties
      }
      let {data} = await cities(countyId, 4)
      this.streets = data
      return data
    },
    // 根据第一个省份查询 城市，县，街道
    async getAllByFirstProvinceId () {
      let provinces = await this.$store.dispatch('initProvinces')
      this.provinces = provinces
      let cities = await this.getCities(provinces[0].id)
      let counties = await this.getCountie(cities[0].id)
      let streets = await this.getStreets(counties[0].id)

      return [
        provinces,
        cities,
        counties,
        streets
      ]
    },
    async getAllByIds (provinceId = 0, cityId = 0, countyId = 0) {
      let provinces = await this.$store.dispatch('initProvinces')
      this.provinces = provinces
      if (!provinceId) {
        provinceId = provinces[0].id
      }

      let cities = await this.getCities(provinceId)
      if (!cityId) {
        cityId = cities[0].id
      }

      let counties = await this.getCountie(cityId)
      if (!countyId) {
        countyId = counties[0].id
      }
      let streets = await this.getStreets(countyId)
      return [
        provinces,
        cities,
        counties,
        streets
      ]
    },
    // 根据省份ID查询 城市，县，街道
    async getAllByProvinceId (provicenId) {
      let cities = await this.getCities(provicenId)
      let counties = await this.getCountie(cities[0].id)
      let streets = await this.getStreets(counties[0].id)

      return [
        cities,
        counties,
        streets
      ]
    },
    // 根据省下 第一个城市，县，街道
    async getAllByCityId (cityId) {
      let counties = await this.getCountie(cityId)
      let streets = await this.getStreets(counties[0].id)
      return [
        counties,
        streets
      ]
    },
    // 加锁 避免多次查询
    lockArea () {
      this.locked = true
    },
    // 加锁 避免多次查询
    unLockArea () {
      setTimeout(() => {
        this.locked = false
      }, 10)
    },
    // 查询是否已经锁上，之后不在执行
    isLocked () {
      return this.locked === true
    },
    wrapLock (fn) {
      if (this.isLocked()) {
        return
      }
      fn()
    },
    forceLock (fn, timeout = 50) {
      if (this.isLocked()) {
        return
      }
      this.lockArea()
      setTimeout(() => {
        fn()
        this.unLockArea()
      }, timeout)
    }
  }
}
