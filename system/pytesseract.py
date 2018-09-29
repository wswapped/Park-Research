import cv2

img = cv2.imread('/bin/samples/rdf.jpg')
cv
print(pytesseract.image_to_string(img))
# OR explicit beforehand converting
print(pytesseract.image_to_string(Image.fromarray(img))