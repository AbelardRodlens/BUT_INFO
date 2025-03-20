const User = require("../../models/User.js");
const Game = require("../../models/Game.js");
const jwt = require("jsonwebtoken");
const cookieParser = require("cookie-parser");
const { sign } = require("cookie-signature");
const bcrypt = require("bcrypt");
const mongoose = require("mongoose");
// const nodemailer = require('nodemailer');
const apiFunctions = require("../../api_functions.js");




jest.mock("mongoose", () => ({
  ...jest.requireActual("mongoose"),
  model: jest.fn((modelName) => {
    if (modelName === "Games") {
      return {
        findOne: jest.fn().mockResolvedValue({
          game_id: 1,
          title: "Journey",
          description: "A third-person adventure game...",
          genres: ["Platform", "Adventure"],
          platforms: ["PC", "PlayStation 4"],
          developers: ["ThatGameCompany"],
          publishers: ["Sony"],
        }),
        find: jest.fn().mockResolvedValue([
          { game_id: 2, title: "Game 2", genres: ["Action"] },
          { game_id: 3, title: "Game 3", genres: ["Adventure"] },
        ]),
        sort: jest.fn().mockReturnThis(),
        limit: jest.fn().mockReturnThis(),
      };
    } else if (modelName === "Users") {
      return {
        findOne: jest.fn().mockResolvedValue({
          user_id: 3316,
          username: "username_3316",
          email: "3316@gmail.com",
          pass: "$2b$10$hashedPassword",
        }),
        updateOne: jest.fn().mockResolvedValue({
          acknowledged: true,
          matchedCount: 1,
          modifiedCount: 1,
        }),
        deleteOne: jest.fn().mockResolvedValue({
          acknowledged: true,
          deletedCount: 1,
        }),
      };
    }
    return {};
  }),
}));


jest.mock('jsonwebtoken');
jest.mock('../../models/Game');
jest.mock('../../models/User');

jest.mock('bcrypt',() => {
    return {
        hash: jest.fn().mockResolvedValue("hashPassword12*"),
        compare: jest.fn().mockResolvedValue(true)
    }
})

afterEach(() => {
  // Nettoyage des mocks/timers
  jest.clearAllTimers();
  jest.restoreAllMocks();
});

// 

describe('API Functions Unit Tests', () => {
  describe('searchGames', () => {
    beforeEach(() => {
      Game.find.mockImplementation(() => ({
        skip: jest.fn().mockImplementation(() => ({
          limit: jest.fn().mockImplementation(() => [{ title: 'Game1' }, { title: 'Game2' }]),
        })),
      }));
    });

    test('should return games for valid filters', async () => {
      // Arrange
      const query = { title: 'Game' };
      const pageNumber = 1;

      // Act
      const result = await apiFunctions.searchGames(query, pageNumber);

      // Assert
      expect(result).toEqual([{ title: 'Game1' }, { title: 'Game2' }]);
    });

    test('should throw error if no games are found', async () => {
      // Arrange
      Game.find.mockImplementation(() => ({
        skip: jest.fn().mockImplementation(() => ({
          limit: jest.fn().mockResolvedValue([]),
        })),
      }));
      const query = { title: 'Nonexistent' };
      const pageNumber = 1;

      // Act & Assert
      await expect(apiFunctions.searchGames(query, pageNumber)).rejects.toThrow('Aucun jeu trouvé pour les critères spécifiés.');
    });

    test('should throw error if query is missing', async () => {
      // Arrange
      const query = undefined;
      const pageNumber = 1;

      // Act & Assert
      await expect(apiFunctions.searchGames(query, pageNumber)).rejects.toThrow('filters argument must be an object.');
    });

    test('should throw error for unexpected database error', async () => {
      // Arrange
      Game.find.mockImplementation(() => ({
        skip: jest.fn().mockImplementation(() => ({
          limit: jest.fn().mockRejectedValue(new Error('Unexpected error')),
        })),
      }));
      const query = { title: 'Game' };
      const pageNumber = 1;

      // Act & Assert
      await expect(apiFunctions.searchGames(query, pageNumber)).rejects.toThrow('Unexpected error');
    });
  });
});
