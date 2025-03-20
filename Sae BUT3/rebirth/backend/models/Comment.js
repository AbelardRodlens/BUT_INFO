const mongoose = require("mongoose");

const Schema = mongoose.Schema;

const commentSchema = new Schema({
    comment_id: { type: Number, required: true },
    user_id: { type: Number, required: true },
    game_id: { type: Number, required: true },
    content: { type: String, required: true },
    parent_id: { type: Number, required: true },
    likes: { type: [Number], default: [] },
    created_at: { type: Date, required: true }
  });

  commentSchema.pre("save", async function (next) {
      if (!this.isNew) return next();
  
      try {
        const lastComment = await mongoose.model('Comment').findOne().sort({ comment_id: -1 });
        this.comment_id = lastComment? lastComment.comment_id + 1 : 1;
  
        const reordered = {
          _id: this._id, 
          comment_id: this.comment_id,
          ...this.toObject() 
        };
  
        Object.assign(this, reordered);
  
        next();
      } catch (e) {
        next(e);
      }
      
    });
  
  module.exports = mongoose.model('Comment', commentSchema);