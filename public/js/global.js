String.prototype.parseHashtag = function() {
    return this.replace(/[#]+^[ ,，]+/g, function(t) {
        var tag = t.replace("#","%23")
        return t.link("http://search.twitter.com/search?q="+tag);
    });
};
test = "Simon is writing a post about #我们, #哈哈 #and parsing hashtags as URLs";
document.writeln(test.parseHashtag());