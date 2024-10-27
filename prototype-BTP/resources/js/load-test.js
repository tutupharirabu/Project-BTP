import http from 'k6/http';
import { check, sleep } from 'k6';
import { group } from 'k6';

export const options = {
  stages: [
    { duration: '30s', target: 50 },
    { duration: '1m', target: 75 },
    { duration: '30s', target: 0 },
  ],
  thresholds: {
    http_req_duration: ['p(95)<500'],
  },
};

const BASE_URL = 'https://spacerentbtp.my.id';
const LOGIN_URL = `${BASE_URL}/login`;
const LOGOUT_URL = `${BASE_URL}/logout`;

export default function () {
  group('Penyewa Pages', function () {
    let res = http.get(`${BASE_URL}/dashboardPenyewa`);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(`${BASE_URL}/daftarRuanganPenyewa`);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(`${BASE_URL}/detailRuanganPenyewa/1`);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);
  });

  group('Admin Pages', function () {
    let res = http.get(LOGIN_URL);
    let csrfToken = res.html().find('input[name="_token"]').attr('value');
    let payload = JSON.stringify({
        email: 'dhilPetugas@gmail.com',
        password: 'dhil1234',
        _token: csrfToken
    });

    let params = {
        headers: {
            'Content-Type': 'application/json'
        }
    };

    let loginRes = http.post(LOGIN_URL, payload, params);
    const cookies = res.cookies;

    check(res, {
      'login successful': (r) => r.status === 200,
    });

    params.cookies = cookies;

    res = http.get(`${BASE_URL}/dashboardAdmin`, params);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(`${BASE_URL}/daftarRuanganAdmin`, params);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(`${BASE_URL}/statusPengajuanAdmin`, params);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(LOGOUT_URL, params);
    check(res, { 'logout successful': (r) => r.status === 200 });
  });

  group('Public Pages', function () {
    let res = http.get(LOGIN_URL);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(`${BASE_URL}/daftarPenyewa`);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);

    res = http.get(`${BASE_URL}/meminjamRuangan`);
    check(res, { 'status was 200': (r) => r.status === 200 });
    sleep(1);
  });
}
