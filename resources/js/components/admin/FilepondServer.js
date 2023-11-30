export default function FilepondServer(product_id) {
    return {
        remove(filename, load) {
            load('1')
        },
        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
            const formData = new FormData()
            formData.append(fieldName, file, file.name)
            formData.append('product_id', product_id ? product_id : null)
            const request = new XMLHttpRequest()
            request.open('POST', '/_admin/file/upload')
            request.upload.onprogress = (e) => {
                progress(e.lengthComputable, e.loaded, e.total)
            }
            request.onload = function() {
                if (request.status >= 200 && request.status < 300) {
                    load(request.responseText)
                }
                else {
                    error('oh no')
                }
            }
            request.send(formData)
            return {
                abort: () => {
                    request.abort()
                    abort()
                }
            }
        },
        revert: (filename, load) => {
            load(filename)
        },
        load: (source, load, error, progress, abort, headers) => {
            var myRequest = new Request(source)
            fetch(myRequest).then(function(response) {
                response.blob().then(function(myBlob) {
                    load(myBlob)
                })
            })
        },
    }
}