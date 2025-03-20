const mongoose = require("mongoose");

const tokenSchema = new mongoose.Schema({
    token: { type: String, required: true },
    type: { type: String, enum: ['access', 'refresh'], required: true },
    user_id: { type: Number, required: true },
    createdAt: { type: Date, default: Date.now },
    expiredAt: { type: Date, require: true },
    isRevoked: { type: Boolean, default: false },
    revokedAt: { type: Date, default: null },
    ipAddress: { type: String, require: true },
    deviceInfo: { type: String, require: true},
  });


const userSchema = new mongoose.Schema({
    user_id: { type: Number, unique: true, index: true },
    username: { type: String, required: true },
    pass: { type: String, required: true },
    email: { type: String, unique: true, required: true },
    tokens:{ type: [tokenSchema], default: [] },
    game_list: { type: [Number], default: [] },
    profile_picture: { type: String, default: 'https://i.pinimg.com/736x/38/d7/1e/38d71ee59724a95fe5877dd06d78d844.jpg' },
    bio: {type: String, default: "Personnalisez votre bio"},
    createdAt: { type: Date, default: Date.now },
    deletionDate: { 
      type: Date,
      default: () => new Date( Date.now() + 3 * 24 * 3600 * 1000 ),
      expires: 0,
    },
    registrationToken: {type: String} 
  });

  userSchema.pre("save", async function (next) {
    if (!this.isNew) return next();

    try {
      const lastUser = await mongoose.model('User').findOne().sort({ user_id: -1 });
      this.user_id = lastUser ? lastUser.user_id + 1 : 1;

      const reordered = {
        _id: this._id, 
        user_id: this.user_id,
        ...this.toObject() 
      };

      Object.assign(this, reordered);

      next();
    } catch (e) {
      next(e);
    }
    
  });

  module.exports = mongoose.model('User', userSchema);