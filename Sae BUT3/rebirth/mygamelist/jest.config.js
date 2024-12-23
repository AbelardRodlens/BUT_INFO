export default {
  testEnvironment: "node", // Configure Jest pour un environnement Node.js
   transform: {
    '^.+\\.[t|j]sx?$': 'babel-jest', // Si vous utilisez JSX ou ES6
  },
  moduleFileExtensions: ['js', 'jsx', 'json', 'node'],
  };