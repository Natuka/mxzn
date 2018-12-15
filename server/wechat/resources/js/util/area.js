// import { data } from '../config/citydata'

import { getApi } from './axios'

export const provinces = []
export const provinceFlat = {}
export const flat = {}
export const cities = []
export const cityFlat = {}
export const conties = []
export const countyFlat = {}

export const provinceNames = {}
export const cityNames = {}
export const countyNames = {}

getApi('/js/area.json')
    .then(init)
    .catch(e => console.log('init data failed ', e))

const init = data => {
    console.log('data', data)
    data.forEach(city => {
        city.code = city.id
        city.text = city.name
        city.map = {}
        city.children = []
        flat[city.id] = city
        if (city.level_type === 1) {
            provinceNames[city.name] = city
            provinceFlat[city.id] = city
            provinces.push(city)
        } else if (city.level_type === 2) {
            cityNames[city.name] = city
            cityFlat[city.id] = city
            cities.push(city)
        } else if (city.level_type === 3) {
            countyNames[city.name] = city
            conties.push(city)
        }
    })

    cities.forEach(city => {
        const province = provinceFlat[city.parent_id]
        if (!province) {
            return
        }
        province.children.push(city)
        province.map[city.name] = city
    })

    conties.forEach(county => {
        const city = cityFlat[county.parent_id]
        if (!city) {
            return
        }
        city.children.push(county)
        city.map[county.name] = county
    })
}

export function getName(areaId) {
    const area = flat[areaId]
    return (area && area.name) || ''
}

export function getChildren(areaId) {
    const area = flat[areaId]
    if (area && area.children && area.children.length) {
        return area.children
    }
    return []
}

export function getNamesByIds(provinceId, cityId, countyId) {
    const provinceName = (flat[provinceId] && flat[provinceId].name) || ''
    const cityName = (flat[cityId] && flat[cityId].name) || ''
    const countyName = (flat[countyId] && flat[countyId].name) || ''

    if (!provinceName || !cityName || !countyName) {
        return []
    }
    return [provinceName, cityName, countyName]
}

// 获取下拉选择项
export function getNames() {
    const names = []
    provinces.forEach(({ name, children }) => {
        const _cities = []
        if (children && children.length) {
            children.forEach(({ children, name }) => {
                if (children && children.length) {
                    const counties = children.map(county => county.name)
                    _cities.push({
                        [name]: counties
                    })
                }
            })

            names.push({
                [name]: _cities
            })
        }
    })

    return names
}

export function getIdsByName(
    provinceName = '',
    cityName = '',
    countyName = ''
) {
    const province = provinceNames[provinceName]
    const city = province && province.map[cityName]
    const county = city && city.map[countyName]

    return [
        province ? province.id : 0,
        city ? city.id : 0,
        county ? county.id : 0
    ]
}
