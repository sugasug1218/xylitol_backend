var axios = require('axios');
var FormData = require('form-data');
var data = new FormData();
data.append('email', 'test@example.com');

var config = {
    method: 'post',
    url: 'http://localhost:8080/api/preRegister',
    headers: {
        'Cookie': '__gads=ID=e520b1b0981bba40-22b9385b65d30001:T=1653451257:RT=1653451257:S=ALNI_MYDy1adjHlSFOBXPJ1DhIy6r5kRUA; __gpi=UID=000005b5eea99940:T=1653451257:RT=1653882000:S=ALNI_MaGLAIQNRHhXryor5069wWgZk98oQ; _ga=GA1.1.1943542510.1653451257; adminer_key=71db92d84db2fa10808cd1353060a2a5; adminer_permanent=c2VydmVy-bXlzcWw%3D-YXBpX3VzZXI%3D-YXBpX2Ri%3Ay8Zbqey7Y2%2BEF9Jb; adminer_settings=; adminer_sid=32b0e653f447c058afc68abfa96ddd79; adminer_version=4.8.1',
        ...data.getHeaders()
    },
    data: data
};

axios(config)
    .then(function (response) {
        console.log(JSON.stringify(response.data));
    })
    .catch(function (error) {
        console.log(error);
    });
