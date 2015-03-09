/* NOTE:  This is a custom stack implementation.  It was used to add Undo and Redo features to a provided image manipulation program.

 * William Smyth May
 * 2014-10-08
 * This is the ImageStack for handling Undo and Redo for CSE 373 Assignment 1
 * Holds BufferedImage objects
 */

import java.awt.Graphics;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.util.*;

/**
 * @author William Smyth May
 *
 */
public class ImageStack {
	private List<BufferedImage> imageItems; //ArrayList of BufferedImage to be used as a stack.
	private boolean lastPop; //True if pop was the last pop, push, or clear method was a pop, initially false.
	
	//Constructor for a new instance of an ImageStack
	public ImageStack() {
		imageItems = new ArrayList<BufferedImage>();
		lastPop = false;
	}
	
	//Adds a new BufferedImage to the top of the ImageStack
	public void push(BufferedImage dataItem) {
		imageItems.add(0, dataItem);
		lastPop = false;
	}
	
	//Returns and removes the last-stacked BufferedImage
	//Throws an EmptyStackException if the stack is empty
	public BufferedImage pop() {
		lastPop = true;
		if (imageItems.size() > 0) {
			BufferedImage popped = imageItems.get(0);
			imageItems.remove(0);
			return popped;
		} else {
			throw new EmptyStackException();
		}
	}
	
	//Returns the top item on the stack, but does not remove it
	//Throws an EmptyStackException if the stack is empty
	public BufferedImage peek() {
		if (imageItems.size() > 0) {
			return imageItems.get(0);
		} else {
			throw new EmptyStackException();
		}
	}
	
	//Returns true if the stack is empty, false if it is not
	public boolean isEmpty() {
		return imageItems.size() == 0;
	}
	
	//Completely empties the stack.
	public void clear() {
		imageItems.clear();
		lastPop = false;
	}
	
	//Determines if the last clear, push, or pop method was a pop
	//Returns true if yes, false if not
	public boolean popWasLast() {
		return lastPop;
	}
	
	//Returns the current size of the stack
	public int getSize() {
		return imageItems.size();
	}
}
