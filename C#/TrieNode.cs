using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WebRole1
{
    public class TrieNode
    {
        public char Letter { get; set; }
        public const char eow = '$';
        public Dictionary<char, TrieNode> Children { get; private set; }

        public TrieNode(char letter)
        {
            this.Letter = letter;
            this.Children = new Dictionary<char, TrieNode>();
        }

        public TrieNode this[char index]
        {
            get { return (TrieNode)Children[index]; }
        }

        /// <summary>
        /// Adds a child letter to the TrieNode
        /// </summary>
        /// <param name="letter">letter to be added</param>
        /// <returns>New TrieNode</returns>
        public TrieNode AddLetter(char letter)
        {

            if (!Children.ContainsKey(letter))
            {
                char node = letter;
                Children.Add(letter, new TrieNode(letter));

            }

            return (TrieNode)Children[letter];
        }

        /// <summary>
        /// Verifies that a key is in the TrieNode
        /// </summary>
        /// <param name="key">Key to be checked</param>
        /// <returns>True or false</returns>
        public bool ContainsKey(char key)
        {
            return Children.ContainsKey(key);
        }

        /// <summary>
        /// Returns all keys in the Node
        /// </summary>
        /// <returns>An array of the keys (characters)</returns>
        public char[] Keys()
        {
            return Children.Keys.ToArray();
        }
    }
}