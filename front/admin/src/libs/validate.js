// 数字
export const number = (message, trigger = 'change') => {
  return {
    validator: (rule, value, callback) => {
      if (value <= 0) {
        error(message, callback)
        return
      }
      callback()
    },
    trigger
  }
}

// 最小值
export const min = (min = 0, message, trigger = 'change') => {
  return {
    validator: (rule, value, callback) => {
      if (value <= min) {
        error(message, callback)
        return
      }
      callback()
    },
    trigger
  }
}

export const between = (min = 0, max = 0, message, trigger = 'change') => {
  return {
    validator: (rule, value, callback) => {
      if (value < min || value > max) {
        error(message, callback)
        return
      }
      callback()
    },
    trigger
  }
}

export const notEmpty = (message = '', trigger = 'change') => {
  return {
    required: true,
    message,
    trigger
  }
}

const error = (message, callback) => callback(new Error(message))
