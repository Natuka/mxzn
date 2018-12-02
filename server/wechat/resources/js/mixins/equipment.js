export default {
    data() {
        return {
            equipments: []
        }
    },
    computed: {
        equipmentsText() {
            if (!this.equipments.length) {
                return []
            }
            return this.equipments.map(e => e.name + ' ' + e.model)
        }
    },
    methods: {
        async fetchEquipmentList() {
            try {
                const data = await this.$api.fetchEquipmentList()
                // console.log('data', data)
                this.equipments = data
            } catch (e) {
                console.log('fetchEquipmentList', e)
            }
        },
        getEquipmentIdByText(name, index) {
            const eq = this.equipments.find(
                e => name === e.name + ' ' + e.model
            )
            console.log('getEquipmentIdByText', eq)
            return eq
        }
    }
}
