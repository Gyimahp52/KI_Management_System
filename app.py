import os
from flask import Flask, request, jsonify, session
from flask_cors import CORS
from langchain.document_loaders import WebBaseLoader
from langchain_community.document_loaders import PyPDFLoader
import google.generativeai as genai
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.vectorstores import FAISS
from langchain.embeddings import GooglePalmEmbeddings

app = Flask(__name__)
app.secret_key = '616d9ee5da5b46c39048e108e718c7a9'  # Set a secret key for sessions
CORS(app)

os.environ["GOOGLE_API_KEY"] = 'AIzaSyBkpkOJMjbADblWa7jsRxJtFsNSG9QW3Pw'
genai.configure(api_key=os.environ["GOOGLE_API_KEY"])

def load_documents():
    urls = [
        "https://openmindafrica.org/",
        "https://openmindafrica.org/about-oma/",
        "https://openmindafrica.org/ki-partner-schools/",
        "https://openmindafrica.org/benefits-schools/",
        "https://openmindafrica.org/contact/"
    ]
    web_loader = WebBaseLoader(urls)
    web_documents = web_loader.load()

    pdf_loader = PyPDFLoader("data.pdf")
    pdf_documents = pdf_loader.load()

    return web_documents + pdf_documents

def get_text_chunks(documents):
    text_splitter = RecursiveCharacterTextSplitter(chunk_size=1000, chunk_overlap=200)
    return text_splitter.split_documents(documents)

def get_vector_store(chunks):
    embeddings = GooglePalmEmbeddings()
    vector_store = FAISS.from_documents(chunks, embeddings)
    vector_store.save_local("faiss_index", allow_dangerous_deserialization=True)
    return vector_store

def ask_question(question, conversation_history):
    embeddings = GooglePalmEmbeddings()
    vector_store = FAISS.load_local("faiss_index", embeddings, allow_dangerous_deserialization=True)
    relevant_docs = vector_store.similarity_search(question, k=3)
    context = "\n".join([doc.page_content for doc in relevant_docs])
    
    model = genai.GenerativeModel('gemini-pro')
    prompt = f"""You are a friendly and helpful assistant for KINESTHETIC INTELLIGENCE EDUCATION (KIE). 
    Your role is to provide helpful, accurate, and friendly information about KIE to users.

    Here are some guidelines for your responses:
    1. Always maintain a friendly and professional tone.
    2. If you're not sure about something, say so politely and offer to help with related information you do know.
    3. Provide concise answers for simple questions, but offer more detailed explanations for complex topics.
    4. If a user expresses interest in a topic, offer to expand on it or suggest related areas they might find interesting.
    5. Always prioritize information directly related to KIE and its benefits for education.
    6. If a user asks about something not directly related to KIE, try to bridge the topic back to relevant KIE concepts if possible.
    7. when asked for a link on KIE, refer user to https://openmindafrica.org/
    8. Be encouraging and positive about the benefits of KIE, but remain factual and avoid exaggeration..
    
    Context: {context}
    
    Conversation History:
    {conversation_history}
    
    Human: {question}
    Assistant:"""
    
    response = model.generate_content(prompt)
    return response.text, relevant_docs

@app.route('/')
def index():
    return "Welcome to the Open Mind Africa RAG API"

@app.route('/process_docs', methods=['POST'])
def process_docs():
    all_documents = load_documents()
    chunks = get_text_chunks(all_documents)
    get_vector_store(chunks)
    return jsonify({"message": "Documents processed and indexed successfully."})

@app.route('/chat', methods=['POST'])
def chat():
    user_message = request.json.get('message')
    if not user_message:
        return jsonify({'error': 'No message provided'}), 400
    
    if 'conversation_history' not in session:
        session['conversation_history'] = []
    
    conversation_history = "\n".join(session['conversation_history'][-5:])  # Keep last 5 exchanges
    
    answer, sources = ask_question(user_message, conversation_history)
    
    session['conversation_history'].append(f"Human: {user_message}")
    session['conversation_history'].append(f"Assistant: {answer}")
    session.modified = True
    
    return jsonify({
        "response": answer,
        "sources": [{"page_content": source.page_content, "metadata": source.metadata} for source in sources]
    })

if __name__ == '__main__':
    app.run(debug=True)