//William Smyth May
//2013-04-11
//Section: AK

//This is a back-end program which analyzes and evaluates the characters in a string
//and casts them to an array of type int.

import java.util.*;

public class LetterInventory {
	public static final int LETTER = 26;
	private int[] letterCount;
	private int letterNum;
	private int size;
	
	//Constructor.  Takes the string, analyzes the characters, and creates an int array where the
	//number of each letter is kept.  Only accepts letters, and all letters are converted to lower
	//case.
	public LetterInventory(String data) {
		letterCount = new int[LETTER];
		for (int i = 0; i < data.length(); i++) {
			letterNum = data.toLowerCase().charAt(i) - 'a';
			if (letterNum >= 0 && letterNum <=25) {
				letterCount[letterNum]++;
				size++;
			}	
		}
	}
	
	//Returns the size of the constructed array.
	public int size() {		
		return size;
	}
	
	//Evaluates if the constructed array is empty.
	public boolean isEmpty() {
		return (size == 0);
	}
	
	//pre : Assumes that there are numbers in the array.
	//post: Returns the number of times a given letter occured in the string.
	//if a non alphabetic character is passed, an IllegalArgumentException is thorwn.
	public int get(char letter) {
		char ch = Character.toLowerCase(letter);
		if (ch > 'z' || ch < 'a') {
			throw new IllegalArgumentException();
		}	
		int num = ch - 'a';
		int total = letterCount[num];
		return total;
	}
	
	//pre : There is a 26 element array with a count for each letter of the alphabet.
	//post: A string of all the letters is returned in alphabetical order, with equal number
	//		  letters that are in the original string.
	public String toString() {
		String result = "[";	
		for (int i = 0; i < LETTER; i++) {
			char string = (char)(i + 'a');
			for (int j = 0; j < letterCount[i]; j++) {
				result += string;
			}
		}
		return result + "]";
	}
	
	//pre : The array has a set value at a given index.
	//post: The client specifies the number of times they want a given letter to occur.
	//If a non-alphabetic character is passed, or if a negative value is specified,
	//throws IllegalArgumentException.
	public void set(char letter, int value) {
		int newLetter = (Character.toLowerCase(letter) - 'a');
		if (newLetter > 'z' || newLetter < 'a' || value < 0) {
			throw new IllegalArgumentException();
		}
		if (letterCount[newLetter] > value) {
			size -= letterCount[newLetter];
		}		
		letterCount[newLetter] = value;
		size += value;
	}
	
	//pre : The client has 2 int arrays they wish to add together.
	//post: A third LetterInventory that is the sum of the first two is returned.
	public LetterInventory add(LetterInventory other) {
		LetterInventory here = new LetterInventory();
		for (int i = 0; i < LETTER; i++) {
			here.letterCount[i] = letterCount[i] + other.letterCount[i];
		}
		here.size = size + other.size;
		return here;
	}
	
	//pre : The client has 2 int arrays they wish to subtract.
	//post: A third LetterInventory is returned that is the difference of the two.
	//If the result would be negative, null is returned.
	public LetterInventory subtract(LetterInventory other) {
		LetterInventory now = new LetterInventory();
		for (int i = 0; i < LETTER; i++) {
			now.letterCount[i] = letterCount[i] - other.letterCount[i];
			if (now.letterCount[i] < 0) {
				return null;
			}	
		}
		now.size = size - other.size;			
		return now;
	}
	
	//Second constructor to create LetterInventories for the add and subtract methods.
	private LetterInventory() {
		this("");
	}							
}				
