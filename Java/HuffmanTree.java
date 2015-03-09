//William Smyth May
//2013-06-06
//Section: AK

//This program uses the Huffman method to compress and decompress text files.
import java.util.*;
import java.io.*;

public class HuffmanTree {
	private PriorityQueue<HuffmanNode> sorted; //PriorityQueue sorted on frequency of characters.
	private HuffmanNode newTree; //Reconstructed tree for decoding files.
	
	//Constructor to make the tree from the initial text file.
	//Tree is based on frequency of characters in the file.
	public HuffmanTree(int[] count) {
		sorted = new PriorityQueue<HuffmanNode>();
		for (int i = 0; i < count.length; i++) {
			if (count[i] > 0) {
				sorted.add(new HuffmanNode(count[i], i, null, null));
			}
		}
		makeTree(count);
	}
	
	//This method writes the tree to the specified file.
	public void write(PrintStream output) {
		String path = "";
		write(output, sorted.remove(), path);
	}
	
	//Private helper method for writing the tree.
	//Writes the character and the path of the character to the PrintStream.
	private void write(PrintStream output, HuffmanNode root, String path) {
		if (root.left == null && root.right == null) {
			output.println(root.character);
			output.println(path);
		} else {
			write(output, root.left, path + "0");
			write(output, root.right, path + "1");
		}		
	}
	
	//Private helper method for constructor.
	//Makes the tree of HuffmanNodes based on number of occurence of characters 
	//from the text file.
	private void makeTree(int[] count) {
		sorted.add(new HuffmanNode(1, count.length, null, null));
		while (sorted.size() > 1) {	
			HuffmanNode one = sorted.remove();
			HuffmanNode two = sorted.remove();
			sorted.add(new HuffmanNode(one.count + two.count, 0, one, two));	
		}
	}
	
	//Second constructor for decode method.
	//Rebuilds the tree of HuffmanNodes based on the path given in the code file.
	public HuffmanTree(Scanner input) {
		newTree = new HuffmanNode(0, 0, null, null);
		while (input.hasNextLine()) {
			int code = Integer.parseInt(input.nextLine());
			String path = input.nextLine();
			remakeTree(code, path, newTree);
		}	
	}
	
	//Private helper method for rebuilding the tree from the code file.
	//Relies on newTree field.
	private HuffmanNode remakeTree(int code, String path, HuffmanNode root) {
		if (path.length() == 1 && path.charAt(0) == '0') {
			root.left = new HuffmanNode(0, code, null, null);
			return newTree;
		} else if (path.length() == 1) {
			root.right = new HuffmanNode(0, code, null, null);
			return newTree;			
		} else {
			if (path.charAt(0) == ('0')) {
				if (root.left == null) {
					root.left = new HuffmanNode(0, 0, null, null);
				} 
				return remakeTree(code, path.substring(1), root.left);		
			} else {
				if (root.right == null) {
					root.right = new HuffmanNode(0, 0, null, null);
				}
				return remakeTree(code, path.substring(1), root.right);
			}		
		}
	}
	
	//Method for decoding a .short file back to a human readable file.
	public void decode(BitInputStream input, PrintStream output, int eof) {
		boolean runAgain = true;
		while (runAgain == true) {	
			runAgain = decode(input, output, eof, newTree);					
		}
	}	
	
	//Reconstructs the compressed text using the bits provided by the stream.
	//Stops running when it hits the given End of File value.
	private boolean decode(BitInputStream input, PrintStream output, int eof, HuffmanNode root) {								
		if (root.left == null && root.right == null) {
			if (root.character != eof) {
				output.write(root.character);
				return true;
			} else {
				return false;
			}					
		} else {
			int bit = input.readBit();
			if (bit == 0) {
				return decode(input, output, eof, root.left);
			} else {
				return decode(input, output, eof, root.right);
			}
		}		
	}		
}