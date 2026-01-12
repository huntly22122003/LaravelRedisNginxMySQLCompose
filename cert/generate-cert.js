import { writeFileSync } from 'fs';
import { generateKeyPairSync } from 'crypto';
import forge from 'node-forge';

const { privateKey } = generateKeyPairSync('rsa', { modulusLength: 2048 });
writeFileSync('key.pem', privateKey.export({ type: 'pkcs1', format: 'pem' }));

const forgePrivateKey = forge.pki.privateKeyFromPem(privateKey.export({ type: 'pkcs1', format: 'pem' }));
const cert = forge.pki.createCertificate();
cert.publicKey = forge.pki.setRsaPublicKey(forgePrivateKey.n, forgePrivateKey.e);
cert.serialNumber = '01';
cert.validity.notBefore = new Date();
cert.validity.notAfter = new Date();
cert.validity.notAfter.setFullYear(cert.validity.notBefore.getFullYear() + 1);
cert.setSubject([{ name: 'commonName', value: 'localhost' }]);
cert.setIssuer([{ name: 'commonName', value: 'localhost' }]);
cert.sign(forgePrivateKey);

writeFileSync('cert.pem', forge.pki.certificateToPem(cert));

console.log('Certificate generated!');
