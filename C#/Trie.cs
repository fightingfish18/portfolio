using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WebRole1
{
    public class Trie
    {

        public TrieNode root { get; private set; }
        public Trie()
        {
            root = new TrieNode('#');
        }

        /// <summary>
        /// This method adds a word to the Trie
        /// </summary>
        /// <param name="word">Word to be added</param>
        public void AddWord(string word)
        {
            word = word.ToLower() + TrieNode.eow;
            TrieNode current = root;
            foreach (char c in word)
            {
                current = current.AddLetter(c);
            }
        }

        /// <summary>
        /// This method finds a word in the trie.  Calls a private helper method.
        /// </summary>
        /// <param name="prefix">prefix user has entered in search box</param>
        /// <returns>The found words</returns>
        public List<String> find(string prefix)
        {
            int maxMatches = 10;
            prefix = prefix.ToLower();
            HashSet<string> letterSet = new HashSet<string>();
            string letters = "";
            findMatches(letterSet, maxMatches, prefix, root, letters);
            return letterSet.ToList();
        }

        /// <summary>
        /// Recursive method to find children of prefix in Trie.
        /// </summary>
        /// <param name="results">Found words.</param>
        /// <param name="maxMatches">Maximum number of matches to be returned</param>
        /// <param name="prefix">User entered prefix</param>
        /// <param name="root">Current TrieNode</param>
        /// <param name="letters">String to be converted to returned value</param>
        private static void findMatches(HashSet<string> results, int maxMatches, string prefix, TrieNode root, string letters)
        {
            if (results.Count() == maxMatches)
            {
                return;
            }

            if (root.Letter == TrieNode.eow)
            {
                if (!results.Contains(letters))
                {
                    results.Add(letters);
                }
                return;
            }

            letters += root.Letter.ToString();

            if (prefix.Length > 0)
            {
                if (root.ContainsKey(prefix[0]))
                {
                    char key = prefix[0];
                    findMatches(results, maxMatches, prefix.Remove(0, 1), root[key], letters);
                }
            }
            else
            {
                foreach (char key in root.Keys())
                {
                    findMatches(results, maxMatches, prefix, root[key], letters);
                }

            }
        }
    }
}
