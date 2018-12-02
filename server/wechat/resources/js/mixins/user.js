import dayjs from 'dayjs'

import { getName } from '../util/area'

export default {
    computed: {
        user() {
            return this.$store.getters.user
        },
        currentDatetime() {
            return dayjs().format('YYYY-MM-DD HH:mm:ss')
        },
        customer() {
            return this.$store.getters.customer
        }
    },
    methods: {
        customerAddr() {
            if (!this.customer) {
                return ''
            }
            const { province_id, city_id, district_county_id } = this.customer
            const addr = []
            if (province_id) {
                addr.push(getName(province_id))
            }
            if (city_id) {
                addr.push(getName(city_id))
            }
            if (district_county_id) {
                addr.push(getName(district_county_id))
            }

            if (addr.length) {
                return addr.join('') + this.customer.address
            }
            return this.customer.address
        }
    }
}
