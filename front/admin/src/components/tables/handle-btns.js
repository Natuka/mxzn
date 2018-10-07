const btns = {
  delete: (h, params, vm) => {
    return h('Poptip', {
      props: {
        confirm: true,
        title: '你确定要删除吗?'
      },
      on: {
        'on-ok': () => {
          this.onDelete(params.row)
        }
      }
    }, [
      h('Button', {
        props: {
          type: 'text',
          ghost: true
        },
        on: {
          click: (e) => {
            vm.delayLock()
          }
        }
      }, [
        h('Icon', {
          props: {
            type: 'md-trash',
            size: 18,
            color: '#000000'
          }
        })
      ])
    ])
  }
}

export default btns
