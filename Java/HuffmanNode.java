//William Smyth May
//2013-06-07
//Section: AK

//This class is a Node for the HuffmanTree.
public class HuffmanNode implements Comparable<HuffmanNode> {
	
	public HuffmanNode left; //Next node to the left
	public HuffmanNode right; //Next node to the right
	public int count; //Count of occurences of specified character
	public int character; //ASCII code for given character
	
	//This is the constructor for the HuffmanNode class.
	//Needs 2 ints for data fields, and points to left and right.
	public HuffmanNode(int data, int data2, HuffmanNode left, HuffmanNode right) {
		count = data;
		character = data2;
		this.left = left;
		this.right = right;
	}
	
	//compareTo for HuffmanNode for storing characters in the PriorityQueue.
	public int compareTo(HuffmanNode node2) {
		return count - node2.count;
	}
}				